<div class="row">
    <div class="col-12">
        <h2 class="text-center">Stock Qty Report From {{  date("F jS, Y", strtotime($start_date)) }}
            TO {{  date("F jS, Y", strtotime($end_date)) }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Opening</th>
                    <th>Stock In</th>
                    <th>Stock Out</th>
                    <th>Closing</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $dt)
                    <?php
                    $opening_stock = \App\Modules\StoreInventory\Models\Inventory::openingStockWithStore($start_date, $dt->id, $store_id);
                    $running_stock = \App\Modules\StoreInventory\Models\Inventory::stockInOutWithStore($start_date, $end_date, $dt->id, $store_id);
                    $stock_in = $running_stock['stock_in'];
                    $stock_out = $running_stock['stock_out'];
                    $closing_stock = ($opening_stock + $stock_in) - $stock_out;
                    if ($opening_stock > 0 || $stock_in > 0 || $stock_out > 0 || $closing_stock > 0){
                    ?>
                    <tr>
                        <th scope="row" class="text-center">{{ ++$key }}</th>
                        <td>{{ $dt->name }}</td>
                        <td>{{ $dt->code }}</td>
                        <td>{{ number_format($opening_stock) }}</td>
                        <td>{{ number_format($stock_in) }}</td>
                        <td>{{ number_format($stock_out) }}</td>
                        <td class="text-right">{{ number_format($closing_stock) }}</td>
                    </tr>
                    <?php
                    }
                    ?>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
