<?php

namespace App\Modules\Accounting\Http\Controllers;


use App\DataTables\JournalDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Accounting\Models\ChartOfAccounts;
use App\Modules\Accounting\Models\Journal;
use App\Modules\Accounting\Models\JournalDetails;
use Carbon\Carbon;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Validator;

class JournalController extends BaseController
{
    public $model;

    public function __construct(Journal $model)
    {
        $this->model = $model;
    }

    /**
     * @param JournalDataTable $dataTable
     * @return Factory|View
     */
    public function index(JournalDataTable $dataTable)
    {
        $this->setPageTitle('Journal List', 'List of all Journal');
        return $dataTable->render('Accounting::journal.index');
    }

    public function create()
    {
        $ca = ChartOfAccounts::where('root_id','<>',null)->get();
        $this->setPageTitle('Create Journal', 'Create Journal');
        return view('Accounting::journal.create', compact('ca'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'journal' => 'required',
            'payto' => 'required',
            'grand_total' => 'required|min:1',
        ]);
        $params = $request->except('_token');

        try {
            DB::beginTransaction();
            $journal = new Journal();
            $maxSlNo = $journal->maxSlNo();
            $year = Carbon::now()->year;
            $invNo = "JV-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

            $journal->max_sl_no = $maxSlNo;
            $journal->voucher_no = $invNo;
            $journal->reference = $params['payto'];;
            $journal->type = $params['type'];
            $journal->grand_total = $grand_total = $params['grand_total'];
            $journal->date = $date = $params['date'];
            $journal->created_by = $created_by = auth()->user()->id;
            if ($journal->save()) {
                $journal_id = $journal->id;
                $i = 0;
                $isAnyItemIsMissing = false;
                foreach ($params['journal']['temp_ca_id'] as $ca_id) {
                    $amount = $params['journal']['temp_amount'][$i];
                    $remarks = $params['journal']['temp_remarks'][$i];
                    if ($amount > 0) {
                        $journal_details = new JournalDetails();
                        $journal_details->journal_id = $journal_id;
                        $journal_details->ca_id = $ca_id;
                        $journal_details->remarks = $remarks;
                        $journal_details->amount = $amount;
                        if($journal_details->save()) {

                        }
                    } else {
                        $isAnyItemIsMissing = true;
                    }
                    $i++;
                }

                DB::commit();
                if ($isAnyItemIsMissing == false) {
                    $data = new Journal();
                    $data = $data->where('id', '=', $journal_id);
                    $data = $data->first();

                    $returnHTML = view('Accounting::journal.voucher', compact('data'))->render();
                    return $this->responseJson(false, 200, "Journal Created Successfully.", $returnHTML);
                } else {
                    DB::rollback();
                    return $this->responseJson(true, 200, "Voucher not found!");
                }
            } else {
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
            $data = new Journal();
            $data = $data->where('id', '=', $request->id);
            $data = $data->first();
            if ($data) {
                $returnHTML = view('Accounting::journal.voucher', compact('data'))->render();
                return $this->responseJson(false, 200, "", $returnHTML);
            } else {
                return $this->responseJson(true, 200, "Voucher not found!");
            }
        } else {
            return $this->responseJson(true, 200, "Please insert 55 no!");
        }
    }

    public function delete($id)
    {
        $data = Journal::find($id);
        if ($data->journalDetails()->delete() && $data->delete()) {
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
