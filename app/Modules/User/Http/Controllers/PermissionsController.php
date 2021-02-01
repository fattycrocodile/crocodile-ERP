<?php

namespace App\Modules\User\Http\Controllers;

use App\DataTables\PermissionsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends BaseController
{
    public function index(PermissionsDataTable $dataTable)
    {
        $this->setPageTitle('Permissions', 'List of all permissions');
        return $dataTable->render('User::permissions.index');
    }

    public function create()
    {
        $this->setPageTitle('Create Permission', 'create new Permission');
        return view('User::permissions.create');
    }

    public function store(Request $request)
    {
        //validate Form Data
        $request->validate([
            'name' => "required|min:3",
            'group' => "required",
        ]);

        $permission = Permission::create(['name' => $request->name, 'group'=>$request->group]);

        //save all data to customer table
        if ($permission) {
            //redirect to create customer page
            return $this->responseRedirect('users.permissions.index', 'Permissions added successfully', 'success', false, false);
        } else {
            //redirect to create customer page with previous input
            return $this->responseRedirectBack('Error occurred while creating Permissions.', 'error', true, true);
        }
    }

    public function edit($id)
    {
        $permissions = Permission::find($id);
        $this->setPageTitle('Edit Permissions', 'Edit selected Permissions');
        return view('User::permissions.edit', compact('permissions'));
    }

    public function update(Request $req, $id)
    {
        //validate Form Data
        $req->validate([
            'name' => "required|min:3",
            'group' => "required",
        ]);

        //include Customer model
        $permissions = Permission::findOrFail($id);
        $permissions->name = $req->name;
        $permissions->group = $req->group;

        if ($permissions->update()) {
            //redirect to create customer page
            return $this->responseRedirect('users.permissions.index', 'Permission edited successfully', 'success', false, false);
        } else {
            //redirect to create customer page with previous input
            return $this->responseRedirectBack('Error occurred while editing Permission.', 'error', true, true);
        }

    }

    public function delete($id)
    {
        $data = Permission::find($id);
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
