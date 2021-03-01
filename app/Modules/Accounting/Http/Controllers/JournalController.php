<?php

namespace App\Modules\Accounting\Http\Controllers;


use App\DataTables\JournalDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Accounting\Models\ChartOfAccounts;
use App\Modules\Accounting\Models\Journal;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    public function store()
    {

    }

}
