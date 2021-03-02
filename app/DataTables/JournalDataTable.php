<?php

namespace App\DataTables;


use App\Modules\Accounting\Models\Journal;
use App\Modules\Accounting\Models\MoneyReceipt;
use App\Modules\Accounting\Models\SuppliersPayment;
use App\Modules\StoreInventory\Models\PurchaseReturn;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JournalDataTable extends DataTable
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
            ->addColumn('action', function ($data) {
                return "
                    <div class='form-group'>
                        <div class='btn-group' role='group' aria-label='Basic example'>
                            <button class='btn btn-icon btn-warning btn-preview' value='$data->id' title='Preview'><i class='fa fa-eye'></i></button>
                            <button class='btn btn-icon btn-danger btn-delete' data-remote='journal/$data->id/delete' value='$data->id' title='Delete'><i class='fa fa-trash'></i></button>
                        </div>
                   </div>";
            })
            ->rawColumns(['action'])
            ->removeColumn('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Journal $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Journal $model)
    {
        return $model->newQuery()->orderByDesc('voucher_no');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('journal-table')
            ->setTableAttribute(['class' => 'table table-striped table-bordered dataex-fixh-responsive-bootstrap"'])
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
            Column::make('voucher_no'),
            Column::make('reference')->title('Reference'),
            Column::make('type')->title('Type'),
            Column::make('grand_total')->title('Total'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'PurchaseReturn_' . date('YmdHis');
    }
}
