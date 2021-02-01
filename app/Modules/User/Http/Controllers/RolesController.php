<?php

namespace App\Modules\User\Http\Controllers;

use App\DataTables\RolesDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends BaseController
{
    public function index(RolesDataTable $dataTable)
    {
        $this->setPageTitle('Roles', 'List of all Roles');
        return $dataTable->render('User::roles.index');
    }

    public function create()
    {
        $permission_group = DB::table('permissions')->select('group')->groupBy('group')->orderBy('group', 'asc')->get();
        $this->setPageTitle('Create Roles', 'create new Roles');
        return view('User::roles.create', compact('permission_group'));
    }

    public function store(Request $request)
    {
        //validate Form Data
        $request->validate([
            'name' => "required|min:3|unique:roles",
            'permissions' => "required",
        ]);

        $role = Role::create(["name" => $request->name]);
        $permissions = $request->permissions;

        //save all data to customer table
        if ($role) {
            $role->syncPermissions($permissions);
            return $this->responseRedirect('users.roles.index', 'Role added successfully', 'success', false, false);
        } else {
            //redirect to create customer page with previous input
            return $this->responseRedirectBack('Error occurred while creating Role.', 'error', true, true);
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
        if ($data->delete()) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Record has been deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'status_code' => 200,
                'message' => 'Please try again!',
            ]);
        }
    }
}
