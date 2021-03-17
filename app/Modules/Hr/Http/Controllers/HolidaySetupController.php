<?php

namespace App\Modules\Hr\Http\Controllers;

use App\DataTables\HolidaySetupDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Hr\Models\HolidaySetup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HolidaySetupController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission:holiday.index|holiday.create|holiday.edit|holiday.delete', ['only' => ['index','show']]);
        $this->middleware('permission:holiday.create', ['only' => ['create','store']]);
        $this->middleware('permission:holiday.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:holiday.delete', ['only' => ['delete']]);
    }

    public function index(HolidaySetupDataTable $dataTable)
    {
        $this->setPageTitle('Holiday Setup','List of Holidays');
        return $dataTable->render('Hr::holidaysetup.index');
    }

    public function create()
    {
        $this->setPageTitle('Add Holiday','Add holiday to List of Holidays');
        return view('Hr::holidaysetup.create');
    }

    public function store(Request $req)
    {
        $req->validate([
           'type' =>'required',
           'date'=>'required',
        ]);

        $holiday = new HolidaySetup();
        $holiday->type = $req->type;
        $holiday->date = $req->date;
        $holiday->created_by = auth()->user()->id;
        $holiday->updated_by = auth()->user()->id;

        if (!$holiday->save()) {
            return $this->responseRedirectBack('Error occurred while adding Holidays.', 'error', true, true);
        }
        return $this->responseRedirect('hr.holidaysetup.index', 'Holiday added successfully', 'success', false, false);
    }

    public function edit($id)
    {
        $holidays = HolidaySetup::find($id);
        $this->setPageTitle('Edit Holiday','Edit a holiday from List of Holidays');
        return view('Hr::holidaysetup.edit',compact('holidays'));
    }

    public function update(Request $req,$id)
    {
        $req->validate([
            'type' =>'required',
            'date'=>'required',
        ]);

        $holiday = HolidaySetup::findOrFail($id);
        $holiday->type = $req->type;
        $holiday->date = $req->date;
        $holiday->updated_by = auth()->user()->id;

        if (!$holiday->update()) {
            return $this->responseRedirectBack('Error occurred while editing Holidays.', 'error', true, true);
        }
        return $this->responseRedirect('hr.holidaysetup.index', 'Holiday updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = HolidaySetup::find($id);
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
