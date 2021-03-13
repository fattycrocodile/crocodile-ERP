<div class="row">
    <div class="col-12">
        <h2 class="text-center">Purchase Report From {{  date("F jS, Y", strtotime($start_date)) }}
            TO {{  date("F jS, Y", strtotime($end_date)) }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Date</th>
                    <th>Supplier Name</th>
                    <th class="text-center">PO No</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $grand_total = 0;
                $count = 0;
                ?>
                @foreach($data as $key => $dt)
                    <?php
                    $grand_total += $dt->grand_total;
                    $count++;
                    ?>
                    <tr>
                        <th scope="row" class="text-center">{{ ++$key }}</th>
                        <td class="text-center">{{ $dt->date }}</td>
                        <td>{{ isset($dt->supplier->name)?$dt->supplier->name:"N/A" }}</td>
                        <td class="text-center">{{ $dt->invoice_no }}</td>
                        <td class="text-right">{{ number_format($dt->grand_total, 2) }}</td>
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
