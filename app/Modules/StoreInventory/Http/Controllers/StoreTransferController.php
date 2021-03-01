<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\StoreTransferDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\Inventory;
use App\Modules\StoreInventory\Models\Stores;
use App\Modules\StoreInventory\Models\StoreTransfer;
use App\Modules\StoreInventory\Models\StoreTransferDetails;
use Carbon\Carbon;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreTransferController extends BaseController
{
    public $model;
    public $store;

    public function __construct(StoreTransfer $model)
    {
        $this->model = $model;
        $this->store = new Stores();
    }

    public function index(StoreTransferDataTable $dataTable)
    {
        $this->setPageTitle('Store Transfer', 'List of all Store Transfer');
        return $dataTable->render('StoreInventory::storeTransfer.index');
    }

    public function create()
    {
        $stores = $this->store->treeList();
        $this->setPageTitle('Create Store Transfer', 'Create Store Transfer');
        return view('StoreInventory::storeTransfer.create', compact('stores'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'date' => 'required|date',
            'send_store_id' => 'required|integer',
            'product' => 'required|array',
            'rcv_store_id' => 'required|integer',
        ]);
        $params = $request->except('_token');

        try {
            DB::beginTransaction();
            $invoice = new StoreTransfer();
            $maxSlNo = $invoice->maxSlNo($send_store_id = $params['send_store_id']);
            $year = Carbon::now()->year;
            $invNo = "STF-$send_store_id-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

            $invoice->max_sl_no = $maxSlNo;
            $invoice->invoice_no = $invNo;
            $invoice->send_store_id = $params['send_store_id'];
            $invoice->rcv_store_id = $params['rcv_store_id'];
            $invoice->remarks = $params['remarks'];
            $invoice->is_received = StoreTransfer::IS_PENDING;
            $invoice->date = $date = $params['date'];
            $invoice->created_by = $created_by = auth()->user()->id;
            if ($invoice->save()) {
                $invoice_id = $invoice->id;
                $i = 0;
                $isAnyItemIsMissing = false;
                foreach ($params['product']['temp_product_id'] as $product_id) {
                    $stock_qty = $params['product']['temp_stock_qty'][$i];
                    $transfer_qty = $params['product']['temp_transfer_qty'][$i];
                    $stock_qty = \App\Modules\StoreInventory\Models\Inventory::closingStockWithStore($product_id, $invoice->send_store_id);
                    if ($stock_qty > 0) {
                        $inventory = new Inventory();
                        $inventory->store_id = $send_store_id;
                        $inventory->product_id = $product_id;
                        $inventory->stock_in = 0;
                        $inventory->stock_out = $transfer_qty;
                        $inventory->ref_type = Inventory::REF_STORE_TRANSFER;
                        $inventory->ref_id = $invoice_id;
                        $inventory->date = $date;
                        $inventory->created_by = $created_by;
                        if ($inventory->save()) {
                            $invoiceDetails = new StoreTransferDetails();
                            $invoiceDetails->transfer_id = $invoice_id;
                            $invoiceDetails->product_id = $product_id;
                            $invoiceDetails->qty = $transfer_qty;
                            $invoiceDetails->save();
                        }
                    } else {
                        $isAnyItemIsMissing = true;
                    }
                    $i++;
                }

                DB::commit();
                if ($isAnyItemIsMissing == false) {
                    $data = new StoreTransfer();
                    $data = $data->where('id', '=', $invoice_id);
                    $data = $data->first();

                    $returnHTML = view('StoreInventory::storeTransfer.voucher', compact('data'))->render();
                    return $this->responseJson(false, 200, "Store Transfer Created Successfully.", $returnHTML);
                } else {
                    DB::rollback();
                    return $this->responseJson(true, 200, "Voucher not found!");
                }
            } else {
                DB::rollback();
                return $this->responseJson(true, 200, "Voucher not found!");
            }

        } catch (QueryException $exception) {
            DB::rollback();
            throw new InvalidArgumentException($exception->getMessage());
            //return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
        }
    }

    public function voucher(Request $request)
    {
        if ($request->has('id')) {
            $data = new StoreTransfer();
            $data = $data->where('id', '=', $request->id);
            $data = $data->first();
            if ($data) {
                $returnHTML = view('StoreInventory::storeTransfer.voucher', compact('data'))->render();
                return $this->responseJson(false, 200, "", $returnHTML);
            } else {
                return $this->responseJson(true, 200, "Voucher not found!");
            }
        } else {
            return $this->responseJson(true, 200, "Please insert 55 no!");
        }
    }

    public function receive(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;
            try {
                $invoice = StoreTransfer::findOrFail($id);
                if ($invoice->is_received != StoreTransfer::IS_RECEIVED) {
                    DB::beginTransaction();
                    $invDt = $invoice->storeTransferDetails;
                    $send_store_id = $invoice->send_store_id;
                    $rcv_store_id = $invoice->rcv_store_id;
                    $invoice_id = $id;
                    $invoice->is_received = StoreTransfer::IS_RECEIVED;
                    $invoice->updated_by = $created_by = auth()->user()->id;
                    if ($invoice->save()) {
                        $i = 0;
                        $isAnyItemIsMissing = false;
                        foreach ($invDt as $product) {
                            $product_id = $product->product_id;
                            $transfer_qty = $product->qty;
                            $DT_id = $product->id;
                            $stock_qty = 1;
                            if ($stock_qty > 0) {
                                $inventory = new Inventory();
                                $inventory->store_id = $rcv_store_id;
                                $inventory->product_id = $product_id;
                                $inventory->stock_in = $transfer_qty;
                                $inventory->stock_out = 0;
                                $inventory->ref_type = Inventory::REF_STORE_TRANSFER_RECEIVE;
                                $inventory->ref_id = $invoice_id;
                                $inventory->date = date("Y-m-d");
                                $inventory->created_by = $created_by;
                                if ($inventory->save()) {
                                    $invoiceDetails = StoreTransferDetails::findOrFail($DT_id);
                                    $invoiceDetails->rcv_qty = $transfer_qty;
                                    $invoiceDetails->rcv_date = date("Y-m-d");;
                                    $invoiceDetails->save();
                                }
                            } else {
                                $isAnyItemIsMissing = true;
                            }
                            $i++;
                        }

                        DB::commit();
                        if ($isAnyItemIsMissing == false) {
                            $data = new StoreTransfer();
                            $data = $data->where('id', '=', $id);
                            $data = $data->first();

                            $returnHTML = view('StoreInventory::storeTransfer.voucher', compact('data'))->render();
                            return $this->responseJson(false, 200, "Store Transfer Created Successfully.", $returnHTML);
                        } else {
                            DB::rollback();
                            return $this->responseJson(true, 200, "Voucher not found!");
                        }
                    } else {
                        DB::rollback();
                        return $this->responseJson(true, 200, "Voucher not found!");
                    }
                } else {
                    return $this->responseJson(true, 200, "Already Received! Please try with another one!");
                }

            } catch (QueryException $exception) {
                DB::rollback();
                throw new InvalidArgumentException($exception->getMessage());
                //return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
            }
        }
    }


}
