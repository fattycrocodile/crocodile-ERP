<div class="row">
    <div class="col-12">
        <h2 class="text-center">TSO Wise Order Report From {{  date("F jS, Y", strtotime($start_date)) }}
            TO {{  date("F jS, Y", strtotime($end_date)) }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center;">#</th>
                    <th>Date</th>
                    <th>Store</th>
                    <th>Customer</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $grand_total = 0;
                ?>
                @foreach($data as $key => $dt)
                    <?php
                    $grand_total += $dt->grand_total;
                    ?>
                    <tr>
                        <th scope="row" class="text-center">{{ ++$key }}</th>
                        <td>{{ $dt->date }}</td>
                        <td>{{ $dt->store->name }}</td>
                        <td>{{ $dt->customer->name }}</td>
                        <td class="text-right">{{ number_format($dt->grand_total, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right">GRAND TOTAL</td>
                    <td class="text-right">{{ number_format($grand_total, 2) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
