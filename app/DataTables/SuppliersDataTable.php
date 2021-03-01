<?php

namespace App\DataTables;


use App\Modules\Commercial\Models\Suppliers;
use App\Modules\Crm\Models\Customers;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SuppliersDataTable extends DataTable
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
                            <a href='suppliers/$data->id/edit' class='btn btn-icon btn-secondary'><i class='fa fa-pencil-square-o'></i> Edit</a>
                            <button data-remote='suppliers/$data->id/delete' class='btn btn-icon btn-danger btn-delete'><i class='fa fa-trash-o'></i> Delete</button>
                        </div>
                   </div>";
            })
            ->removeColumn('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Suppliers $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Suppliers $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('suppliers-table')
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
            Column::make('name'),
            Column::make('address'),
            Column::make('contact_no')->title('Phone No'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Suppliers_' . date('YmdHis');
    }
}
