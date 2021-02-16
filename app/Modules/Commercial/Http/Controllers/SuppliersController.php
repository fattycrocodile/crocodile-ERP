<?php

namespace App\Modules\Commercial\Http\Controllers;


use App\DataTables\SellpricesDataTable;
use App\DataTables\SuppliersDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Commercial\Models\Suppliers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuppliersController extends BaseController
{
    public function index(SuppliersDataTable $dataTable)
    {
        $this->setPageTitle('Suppliers','Suppliers List');
        return $dataTable->render('Commercial::suppliers.index');
    }

    public function create()
    {
        $this->setPageTitle('Create Suppliers','Create new Suppliers');
        return view('Commercial::suppliers.create');
    }

    public function store(Request $request)
    {
        //validate Form Data
        $request->validate([
            'name' => "required|min:3",
            'contact_no' => "required|min:11",
            'address' => "required",
        ]);

        //include Customer model
        $suppliers = new Suppliers();
        $suppliers->name = $request->name;
        $suppliers->contact_no = $request->contact_no;
        $suppliers->address = $request->address;
        $suppliers->created_by = auth()->user()->id;
        $suppliers->updated_by = auth()->user()->id;

        //save all data to customer table
        if ($suppliers->save()) {
            //redirect to create customer page
            return $this->responseRedirect('commercial.suppliers.index', 'Supplier added successfully', 'success', false, false);
        } else {
            //redirect to create customer page with previous input
            return $this->responseRedirectBack('Error occurred while creating Supplier.', 'error', true, true);
        }
    }

    public function edit($id)
    {
        $data = Suppliers::find($id);
        $this->setPageTitle('Edit Suppliers', 'Edit selected Supplier');
        return view('Commercial::suppliers.edit', compact('data'));
    }

    public function update(Request $req, $id)
    {
        //validate Form Data
        $req->validate([
            'name' => "required|min:3",
            'contact_no' => "required|min:11",
            'address' => "required",
        ]);

        //include Customer model
        $suppliers = Suppliers::findOrFail($id);
        $suppliers->name = $req->name;
        $suppliers->contact_no = $req->contact_no;
        $suppliers->address = $req->address;
        $suppliers->updated_by = auth()->user()->id;

        if ($suppliers->update()) {
            //redirect to create customer page
            return $this->responseRedirect('commercial.suppliers.index', 'Suppliers edited successfully', 'success', false, false);
        } else {
            //redirect to create customer page with previous input
            return $this->responseRedirectBack('Error occurred while editing Suppliers.', 'error', true, true);
        }

    }

    public function delete($id)
    {
        $data = Suppliers::find($id);
        if($data->delete()) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Record has been deleted successfully!',
            ]);
        } else{
            return response()->json([
                'success' => false,
                'status_code' => 200,
                'message' => 'Please try again!',
            ]);
        }
    }


    public function getSupplierListByName(Request $request): ?JsonResponse
    {
        $response = array();
        if ($request->has('search')) {
            $search = trim($request->search);
            $data = new Suppliers();
            $data = $data->select('id', 'name', 'contact_no');
            if ($search != '') {
                $data = $data->where('name', 'like', '%' . $search . '%');
            }
            $data = $data->limit(20);
            $data = $data->orderby('name', 'asc');
            $data = $data->get();
            if (!$data->isEmpty()) {
                foreach ($data as $dt) {
                    $response[] = array("value" => $dt->id, "label" => $dt->name, 'name' => $dt->name, 'contact_no' => $dt->contact_no);
                }
            } else {
                $response[] = array("value" => '', "label" => 'No data found!', 'name' => '', 'contact_no' => '');
            }
        } else {
            $response[] = array("value" => '', "label" => 'No data found!', 'name' => '', 'contact_no' => '');
        }
        return response()->json($response);
    }

    public function getSupplierListByContactNo(Request $request): ?JsonResponse
    {
        $response = array();
        if ($request->has('search')) {
            $search = trim($request->search);
            $data = new Suppliers();
            $data = $data->select('id', 'name', 'contact_no');
            if ($search != '') {
                $data = $data->where('contact_no', 'like', '%' . $search . '%');
            }
            $data = $data->limit(20);
            $data = $data->orderby('name', 'asc');
            $data = $data->get();
            if (!$data->isEmpty()) {
                foreach ($data as $dt) {
                    $response[] = array("value" => $dt->id, "label" => $dt->contact_no, 'name' => $dt->name, 'contact_no' => $dt->contact_no);
                }
            } else {
                $response[] = array("value" => '', "label" => 'No data found!', 'name' => '', 'contact_no' => '');
            }
        } else {
            $response[] = array("value" => '', "label" => 'No data found!', 'name' => '', 'contact_no' => '');
        }
        return response()->json($response);
    }

}
