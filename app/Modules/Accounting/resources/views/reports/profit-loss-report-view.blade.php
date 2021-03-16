<style>
    .row {
        margin: 0 auto !important;
    }

    .table-custom {
        background-color: #bdc3d4;
    }

    .table-custom:hover {
        background-color: #868e99 !important;
        color: #fff;
    }
</style>

<div class="row d-flex justify-content-center">
    <div class="col-12 col-lg-6 col-sm-12 col-xl-6 col-md-6">
        <h2 class="text-center">
            Profit and Loss Report from {{  date("F jS, Y", strtotime($start_date)) }} To {{  date("F jS, Y", strtotime($end_date)) }}
        </h2>
        <div class="table-responsive ">
            <table class="table table-hover table-xs">
                <thead class="thead-dark">
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Sales</td>
                    <td>(+) {{ number_format($sales, 2) }}</td>
                </tr>
                <tr>
                    <td>Sales Return</td>
                    <td>(-) {{ number_format($salesReturn, 2) }}</td>
                </tr>
                <?php
                $salesRevenue = ($sales - $salesReturn);
                ?>
                <tr class="table-custom">
                    <td>Sales Revenue</td>
                    <td>{{ number_format($salesRevenue, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <?php
                $openingStock = 0;
                $closingStock = 0;
                $today = $end_date;
                ?>
                @foreach($products as $product)
                    <?php
                    $stockOP = \App\Modules\StoreInventory\Models\Inventory::closingStockToDate($product->id, $start_date);
                    $valueOP = $stockOP * \App\Modules\StoreInventory\Models\Product::productAvaragePrice($product->id);
                    $openingStock += $valueOP;
                    $stockCS = \App\Modules\StoreInventory\Models\Inventory::closingStockOfDate($product->id, $today);
                    $valueCS = $stockCS * \App\Modules\StoreInventory\Models\Product::productAvaragePrice($product->id);
                    $closingStock += $valueCS;
                    ?>
                @endforeach

                <tr>
                    <td>Opening Stock</td>
                    <td>(+) {{ number_format($openingStock, 2) }}</td>
                </tr>
                <tr>
                    <td>Purchase</td>
                    <td>(+) {{ number_format($purchase, 2) }}</td>
                </tr>
                <tr>
                    <td>Purchase Return</td>
                    <td>(-) {{ number_format($purchaseReturn, 2) }}</td>
                </tr>
                <tr>
                    <td>Closing Stock</td>
                    <td>(-) {{ number_format($closingStock, 2) }}</td>
                </tr>
                <?php
                $costOfGoodsSold = ($openingStock + $purchase) - ($purchaseReturn + $closingStock);
                ?>

                <tr class="table-custom">
                    <td>Cost of Goods Sold</td>
                    <td> {{ number_format($costOfGoodsSold, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <?php
                $grossProfit = $salesRevenue - $costOfGoodsSold;
                ?>
                <tr class="table-custom">
                    <td>Gross Profit</td>
                    <td> {{ number_format($grossProfit, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <tr class="table-custom">
                    <td>Expense</td>
                    <td>Amount</td>
                </tr>
                <?php
                $totalExpense = 0;
                ?>
                @if($expenses)
                    @foreach($expenses as $expense)
                        <?php
                        $totalExpense += $expense->amount;
                        ?>
                        <tr>
                            <td>{{$expense->name}}</td>
                            <td>{{ number_format($expense->amount, 2) }}</td>
                        </tr>
                    @endforeach
                @endif

                <tr class="table-custom">
                    <td>Total Expense</td>
                    <td>{{ number_format($totalExpense, 2) }}</td>
                </tr>
                <?php
                $netProfit = $grossProfit - $totalExpense;
                ?>
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                </tbody>
                <thead class="thead-dark">
                <tr>
                    <th>NET PROFIT</th>
                    <th>{{ number_format($netProfit, 2) }}</th>

                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
