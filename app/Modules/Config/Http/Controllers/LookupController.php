<?php

namespace App\Modules\Config\Http\Controllers;

use App\DataTables\LookupsDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Config\Models\Lookup;
use Illuminate\Http\Request;

class LookupController extends BaseController
{
    public function index(LookupsDataTable $dataTable)
    {
        $this->setPageTitle('Lookups', 'List of all lookups');
        return $dataTable->render('Config::lookups.index');
    }

    public function create()
    {
        $this->setPageTitle('Create Lookup', 'create new Lookup');
        return view('Config::lookups.create');
    }

    public function store(Request $request)
    {
        //validate Form Data
        $request->validate([
            'name' => "required|min:3",
            'type' => "required",
        ]);

        //include lookups model
        $lookups = new Lookup();
        //find max sn no from customer table
        $maxSn = $lookups->where('type', '=', $request->type)->max('code');
        //Generate new Max SN no
        $Max_sn = $maxSn ? $maxSn + 1 : 1;
        //Assign new max_sn for code
        $lookups->code = $Max_sn;

        //Assigning Form data to customer
        $lookups->name = $request->name;
        $lookups->type = $request->type;

        //save all data to customer table
        if ($lookups->save()) {
            //redirect to create customer page
            return $this->responseRedirect('config.lookups.index', 'Lookup added successfully', 'success', false, false);
        } else {
            //redirect to create customer page with previous input
            return $this->responseRedirectBack('Error occurred while creating Lookup.', 'error', true, true);
        }
    }

    public function edit($id)
    {
        $lookups = Lookup::find($id);
        $this->setPageTitle('Edit Lookup', 'Edit selected Lookup');
        return view('Config::lookups.edit', compact('lookups'));
    }

    public function update(Request $req, $id)
    {
        //validate Form Data
        $req->validate([
            'name' => "required|min:3",
            'type' => "required",
        ]);

        //include Customer model
        $lookups = Lookup::findOrFail($id);
        if ($lookups->type != $req->type) {
            //Get store information by store id
            $maxSn = $lookups->where('type', '=', $req->type)->max('code');
            //Generate new Max SN no
            $Max_sn = $maxSn ? $maxSn + 1 : 1;
            //Assign new max_sn for code
            $lookups->code = $Max_sn;
        }
        $lookups->name = $req->name;
        $lookups->type = $req->type;

        if ($lookups->update()) {
            //redirect to create customer page
            return $this->responseRedirect('config.lookups.index', 'Lookup edited successfully', 'success', false, false);
        } else {
            //redirect to create customer page with previous input
            return $this->responseRedirectBack('Error occurred while editing Lookup.', 'error', true, true);
        }

    }

    public function delete($id)
    {
        $data = Lookup::find($id);
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
}
