<?php

namespace App\DataTables;


use App\Modules\Crm\Models\Customers;
use App\Modules\Hr\Models\Employees;
use App\Modules\StoreInventory\Models\Category;
use App\Modules\StoreInventory\Models\Product;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeesDataTable extends DataTable
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
            ->editColumn('department_id', function ($data) {
                return isset($data->department->name) ? $data->department->name : 'N/A';
            })
            ->editColumn('designation_id', function ($data) {
                return isset($data->designation->name) ? $data->designation->name : 'N/A';
            })
            ->editColumn('gender', function ($data) {
                if ($data->gender == 1 )
                    $string = "MALE";
                else if ($data->gender == 2 )
                    $string = "FEMALE";
                else if ($data->gender == 3 )
                    $string = "OTHERS";
                else
                    $string = "";
                return $string;
            })
            ->editColumn('image', function ($data) {
                if ($photo = $data->image) {
                    $url = asset($data->image);
                    return "<img class='img' style='height: 100px; width: 100px; text-align: center;' src='$url'></img>";
                }
                return '';
            })
            ->addColumn('action', function ($data) {
                return "
                    <div class='form-group'>
                        <div class='btn-group' role='group' aria-label='Basic example'>
                            <a href='employees/$data->id/edit' class='btn btn-icon btn-secondary'><i class='fa fa-pencil-square-o'></i> Edit</a>
                            <button data-remote='employees/$data->id/delete' class='btn btn-icon btn-danger btn-delete'><i class='fa fa-trash-o'></i> Delete</button>
                        </div>
                   </div>";
            })
            ->rawColumns(['image','permanent_address', 'action'])
            ->removeColumn('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Employees $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employees $model)
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
            ->setTableId('employees-table')
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
                ->width(50)
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false)
                ->footer('')
                ->exportable(true)
                ->printable(true),

            Column::make('full_name'),

            Column::make('contact_no')->title('Phone No'),

            Column::make('department_id')->title('Department'),

            Column::make('designation_id')->title('Designation'),

            Column::make('permanent_address')->title('Address'),

            Column::make('gender'),

            Column::make('join_date')->title('Joining Date'),

            Column::make('image')->title('Picture'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Employees_' . date('YmdHis');
    }
}
