<div class="btn-group" role="group" aria-label="Basic example">
    <a href="#" class="btn btn-icon btn-secondary" onclick="printDiv('printableArea')"><i class="fa fa-print"></i>
        Print</a>
</div>
<div class="row" id="printableArea">
    <div class="col-12">
        <h2 class="text-center">Unsold Products Report From {{  date("F jS, Y", strtotime($start_date)) }}
            TO {{  date("F jS, Y", strtotime($end_date)) }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Product Name</th>
                    <th>Product Code</th>
                    <th class="text-center">Stock</th>
                    <th>Stock Value</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $grand_total = 0;
                $count = 0;
                $stockValue = 0;
                ?>
                @foreach($data as $key => $dt)
                    <?php
                    $count++;
                    $stockQty = \App\Modules\StoreInventory\Models\Inventory::closingStock($dt->id);
                    $price = \App\Modules\StoreInventory\Models\Product::productAvaragePrice($dt->id);
                    $stockValue = ($stockQty * $price);
                    $grand_total += $stockValue;
                    ?>
                    <tr>
                        <th scope="row" class="text-center">{{ ++$key }}</th>
                        <td>{{ $dt->name}}</td>
                        <td>{{ $dt->code}}</td>
                        <td class="text-center">{{ $stockQty }}</td>
                        <td class="text-right">{{ number_format($stockValue, 2) }}</td>
                    </tr>
                @endforeach
                @if($count > 0)
                    <tr>
                        <td colspan="4" class="text-right">GRAND TOTAL</td>
                        <td class="text-right">{{ number_format($grand_total, 2) }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="10" class="text-center danger">No data found!</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
