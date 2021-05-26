<?php

namespace App\DataTables;


use App\Model\User\User;
use App\Modules\Accounting\Models\MoneyReceipt;
use App\Modules\Accounting\Models\SuppliersPayment;
use App\Modules\StoreInventory\Models\PurchaseReturn;
use App\Modules\StoreInventory\Models\StoreTransfer;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StoreTransferDataTable extends DataTable
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
            ->editColumn('send_store_id', function ($data) {
                return isset($data->sendStore->name) ? $data->sendStore->name : 'N/A';
            })
            ->editColumn('rcv_store_id', function ($data) {
                return isset($data->receiveStore->name) ? $data->receiveStore->name : 'N/A';
            })
            ->editColumn('is_received', function ($data) {
                return $data->is_received==StoreTransfer::IS_RECEIVED ? "Received" : 'Pending';
            })
            ->addColumn('action', function ($data) {
                $Receive = "";
                if ($data->is_received == StoreTransfer::IS_PENDING) {
                    $Receive = " <button href='store-transfer/$data->id/receive' value='$data->id' class='btn btn-icon btn-success receive-stock' title='Receive Product'><i class='fa fa-calculator'></i></button>";
                }

                return "
                    <div class='form-group'>
                        <div class='btn-group' role='group' aria-label='Basic example'>
                            <button class='btn btn-icon btn-warning btn-preview' value='$data->id' title='Preview'><i class='fa fa-eye'></i></button>
                            $Receive
                        </div>
                   </div>";
            })
            ->rawColumns(['action'])
            ->removeColumn('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param StoreTransfer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StoreTransfer $model)
    {
//        return $model->newQuery()->orderByDesc('invoice_no');
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0){
            return $model->newQuery()->where('rcv_store_id', '=', $store_id)->orderByDesc('invoice_no');
        } else {
            return $model->newQuery()->orderByDesc('invoice_no');
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
            ->setTableId('store-transfer-table')
            ->setTableAttribute(['class' => 'table table-striped table-bordered dataex-fixh-responsive-bootstrap table-condensed'])
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
            Column::make('send_store_id')->title('Send Store'),
            Column::make('rcv_store_id')->title('Receive Store'),
            Column::make('remarks'),
            Column::make('is_received'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'StoreTransfer_' . date('YmdHis');
    }
}
