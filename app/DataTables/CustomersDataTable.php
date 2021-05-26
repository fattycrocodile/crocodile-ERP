<?php

namespace App\DataTables;


use App\Model\User\User;
use App\Modules\Crm\Models\Customers;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomersDataTable extends DataTable
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
            ->addColumn('action', function ($data) {
                return "
                    <div class='form-group'>
                        <div class='btn-group' role='group' aria-label='Basic example'>
                            <a href='customers/$data->id/edit' class='btn btn-icon btn-secondary'><i class='fa fa-pencil-square-o'></i> Edit</a>
                            <button data-remote='customers/$data->id/delete' class='btn btn-icon btn-danger btn-delete'><i class='fa fa-trash-o'></i> Delete</button>
                        </div>
                   </div>";
            })
            ->removeColumn('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Customers $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Customers $model)
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0){
            return $model->newQuery()->where('store_id', '=', $store_id);
        } else {
            return $model->newQuery();
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('customer-table')
            ->setTableAttribute(['class' => 'table table-striped table-bordered dataex-fixh-responsive-bootstrap'])
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px'])
            ->parameters([
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
            ->dom('Bfrtip')
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
//            Column::computed('action')
//                ->exportable(true)
//                ->printable(true)
//                ->width(60)
//                ->addClass('text-center'),
            Column::make('name'),
            Column::make('address'),
            Column::make('contact_no'),
            Column::make('code'),
//            Column::computed('action'),
//            Column::make('created_at'),
//            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Brands_' . date('YmdHis');
    }
}
