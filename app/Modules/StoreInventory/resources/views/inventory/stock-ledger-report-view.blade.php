<div class="row">
    <div class="col-12">
        <h2 class="text-center">Stock Qty Report From {{  date("F jS, Y", strtotime($start_date)) }}
            TO {{  date("F jS, Y", strtotime($end_date)) }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Code</th>
                    <th class="text-center">Stock In</th>
                    <th class="text-center">Stock Out</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $dt)
                    <tr>
                        <th scope="row" class="text-center">{{ ++$key }}</th>
                        <td class="text-center">{{ $dt->date }}</td>
                        <td>{{ \App\Modules\StoreInventory\Models\Product::productName($dt->product_id) }}</td>
                        <td class="text-center">{{ \App\Modules\StoreInventory\Models\Product::productCode($dt->product_id) }}</td>
                        <td class="text-center">{{ number_format($dt->stock_in) }}</td>
                        <td class="text-center">{{ number_format($dt->stock_out) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
