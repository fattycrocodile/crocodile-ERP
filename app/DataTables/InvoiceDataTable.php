<?php

namespace App\DataTables;


use App\Model\User\User;
use App\Modules\Crm\Models\Invoice;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('store_id', function ($data) {
                return isset($data->store->name) ? $data->store->name : 'N/A';
            })
            ->editColumn('customer_id', function ($data) {
                return isset($data->customer->name) ? $data->customer->name : 'N/A';
            })
            ->addColumn('action', function ($data) {
                $delete = $edit = "";
                if ($data->full_paid != Invoice::PAID) {
                    $delete = "<button data-remote='sales/$data->id/delete' class='btn btn-icon btn-danger btn-delete' title='Delete'><i class='fa fa-trash-o'></i></button>";
                }
                return "
                    <div class='form-group text-center'>
                        <div class='btn-group' role='group' aria-label='Basic example'>
                            <a href='sales/$data->id/voucher' class='btn btn-icon btn-warning' title='Invoice Preview'><i class='fa fa-eye'></i></a>
                            $delete
                        </div>
                   </div>";
            })
            ->rawColumns(['action'])
            ->removeColumn('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Invoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0){
            return $model->newQuery()->where('store_id', '=', $store_id)->orderByDesc('invoice_no');
        } else {
            return $model->newQuery()->orderByDesc('invoice_no');
        }
//        return $model->newQuery()->select('*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('invoice-table')
            ->setTableAttribute(['class' => 'table table-striped table-bordered dataex-fixh-responsive-bootstrap'])
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px'])
            ->parameters([
                'dom' => 'Bfrtip',
                'stateSave' => true,
                'order' => [[0, 'desc']],
                'select' => [
                    'style' => 'os',
                    'selector' => 'td:first-child',
                ],
                'buttons' => [
                    ['extend' => 'csv', 'className' => 'btn btn-default btn-md no-corner', 'text' => '<span><i class="fa fa-file-excel-o"></i> csv</span>'],
                    ['extend' => 'excel', 'className' => 'btn btn-default btn-md no-corner', 'text' => '<span><i class="fa fa-download"></i> excel<span class="caret"></span></span>'],
                    ['extend' => 'pdf', 'className' => 'btn btn-default btn-md no-corner', 'text' => '<span><i class="fa fa-file-pdf-o"></i> pdf<span class="caret"></span></span>'],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-md no-corner', 'text' => '<span><i class="fa fa-print"></i> print</span>'],
                    'colvis'
                ],
                'initComplete' => "function () {
                        this.api().columns().every(function () {
                            var column = this;
                            var input = document.createElement(\"input\");
                            input.className = 'form-control';
                            $(input).appendTo($(column.footer()).empty())
                            .on('change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                        });
                }",

            ])
            ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->title('SL')
                ->render(null)
                ->width(100)
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false)
                ->footer('')
                ->exportable(true)
                ->printable(true),
            Column::make('date'),
            Column::make('invoice_no'),

            Column::make('store_id')
                ->title('Store'),
            Column::make('customer_id')
                ->title('Customer'),
            Column::make('grand_total'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Invoice_' . date('YmdHis');
    }
}
