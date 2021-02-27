<div class="row">
    <div class="col-12">
        <h2 class="text-center">Customer Sales Report From {{  date("F jS, Y", strtotime($start_date)) }}
            TO {{  date("F jS, Y", strtotime($end_date)) }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Date</th>
                    <th>Store</th>
                    <th>Customer</th>
                    <th class="text-center">Customer Code</th>
                    <th class="text-center">Total Invoice</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $grand_total = $total_invoice = 0;
                ?>
                @foreach($data as $key => $dt)
                    <?php
                    $grand_total += $dt->customer_total;
                    $total_invoice += $dt->invoice_count;
                    ?>
                    <tr>
                        <th scope="row" class="text-center">{{ ++$key }}</th>
                        <td class="text-center">{{ $dt->date }}</td>
                        <td>{{ $dt->store->name }}</td>
                        <td>{{ $dt->customer->name }}</td>
                        <td class="text-center">{{ $dt->customer->code }}</td>
                        <td class="text-center">{{ $dt->invoice_count }}</td>
                        <td class="text-right">{{ number_format($dt->customer_total, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right">GRAND TOTAL</td>
                    <td class="text-center">{{ number_format($total_invoice) }}</td>
                    <td class="text-right">{{ number_format($grand_total, 2) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
