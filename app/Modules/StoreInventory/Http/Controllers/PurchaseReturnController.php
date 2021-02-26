<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\PurchaseReturnDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Config\Models\Lookup;
use App\Modules\StoreInventory\Models\Inventory;
use App\Modules\StoreInventory\Models\PurchaseReturn;
use App\Modules\StoreInventory\Models\PurchaseReturnDetails;
use App\Modules\StoreInventory\Models\Stores;
use Carbon\Carbon;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends BaseController
{
    public $model;
    public $store;

    public function __construct(PurchaseReturn $model)
    {
        $this->model = $model;
        $this->store = new Stores();
    }

    public function index(PurchaseReturnDataTable $dataTable)
    {
        $this->setPageTitle('Purchase Return', 'List of all Purchase Return');
        return $dataTable->render('StoreInventory::purchaseReturn.index');
    }

    public function create()
    {
        $stores = $this->store->treeList();
        $this->setPageTitle('Create Purchase Return', 'Create Purchase Return');
        return view('StoreInventory::purchaseReturn.create', compact('stores'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'date' => 'required|date',
            'supplier_id' => 'required|integer',
            'product' => 'required|array',
            'grand_total' => 'required|min:1',
        ]);
        $params = $request->except('_token');

        try {
            DB::beginTransaction();
            $invoice = new PurchaseReturn();
            $maxSlNo = $invoice->maxSlNo($supplier_id = $params['supplier_id']);
            $year = Carbon::now()->year;
            $invNo = "RTN-$supplier_id-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

            $invoice->max_sl_no = $maxSlNo;
            $invoice->return_no = $invNo;
            $invoice->purchase_id =  $params['invoice_no'];
            $invoice->store_id = 1;
            $invoice->supplier_id = $params['supplier_id'];
            $invoice->amount = $grand_total = $params['grand_total'];
            $invoice->date = $date = $params['date'];
            $invoice->created_by = $created_by = auth()->user()->id;
            if ($invoice->save()) {
                $invoice_id = $invoice->id;
                $i = 0;
                $isAnyItemIsMissing = false;
                foreach ($params['product']['temp_product_id'] as $product_id) {
                    $stock_qty = $params['product']['temp_stock_qty'][$i];
                    $return_price = $params['product']['temp_return_price'][$i];
                    $return_qty = $params['product']['temp_return_qty'][$i];
                    $row_return_price = $params['product']['temp_row_return_price'][$i];
                    $stock_qty = \App\Modules\StoreInventory\Models\Inventory::closingStockWithStore($product_id, $invoice->store_id);
                    if ($stock_qty > 0) {
                        $inventory = new Inventory();
                        $inventory->store_id = 1;
                        $inventory->product_id = $product_id;
                        $inventory->stock_in = 0;
                        $inventory->stock_out = $return_qty;
                        $inventory->ref_type = Inventory::REF_PURCHASE_RETURN;
                        $inventory->ref_id = $invoice_id;
                        $inventory->date = $date;
                        $inventory->created_by = $created_by;
                        if ($inventory->save()) {
                            $invoiceDetails = new PurchaseReturnDetails();
                            $invoiceDetails->return_id = $invoice_id;
                            $invoiceDetails->product_id = $product_id;
                            $invoiceDetails->qty = $return_qty;
                            $invoiceDetails->price = $return_price;
                            $invoiceDetails->row_total = $row_return_price;
                            $invoiceDetails->save();
                        }
                    } else {
                        $isAnyItemIsMissing = true;
                    }
                    $i++;
                }

                DB::commit();
                if ($isAnyItemIsMissing == false) {
                    return $this->responseRedirectToWithParameters('crm.invoice.voucher', ['id' => $invoice->id], 'Invoice created successfully', 'success', false, false);
                } else {
                    DB::rollback();
                    return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
                }
            } else {
                return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
            }

        } catch (QueryException $exception) {
            DB::rollback();
            throw new InvalidArgumentException($exception->getMessage());
            //return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
        }
    }

}
