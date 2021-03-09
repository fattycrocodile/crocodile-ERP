<div class="row">
    <div class="col-12">
        <h2 class="text-center">Collection Report From {{  date("F jS, Y", strtotime($start_date)) }}
            TO {{  date("F jS, Y", strtotime($end_date)) }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Date</th>
                    <th>MR no</th>
                    <th>Store</th>
                    <th>Customer</th>
                    <th class="text-center">Customer Code</th>
                    <th class="text-center">Invoice No</th>
                    <th class="text-center">Collection Type</th>
                    <th class="text-center">Bank</th>
                    <th class="text-center">Check/Transaction</th>
                    <th class="text-center">Check Date</th>
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
                    $grand_total += $dt->amount;
                    $count++;
                    ?>
                    <tr>
                        <th scope="row" class="text-center">{{ ++$key }}</th>
                        <td class="text-center">{{ $dt->date }}</td>
                        <td class="text-center">{{ $dt->mr_no }}</td>
                        <td>{{ isset($dt->store->name)?$dt->store->name:"N/A" }}</td>
                        <td>{{ isset($dt->customer->name)?$dt->customer->name:"N/A" }}</td>
                        <td class="text-center">{{ isset($dt->customer->code)?$dt->customer->code:"N/A" }}</td>
                        <td class="text-center">{{ $dt->invoice->invoice_no }}</td>
                        <td class="text-center">{{ \App\Modules\Config\Models\Lookup::item('payment_method', $dt->collection_type) }}</td>
                        <td class="text-center">{{ \App\Modules\Config\Models\Lookup::item('bank', $dt->bank_id) }}</td>
                        <td class="text-center">{{  $dt->cheque_no }}</td>
                        <td class="text-center">{{  $dt->cheque_date }}</td>
                        <td class="text-right">{{ number_format($dt->amount, 2) }}</td>
                    </tr>
                @endforeach
                @if($count > 0)
                <tr>
                    <td colspan="11" class="text-right">GRAND TOTAL</td>
                    <td class="text-right">{{ number_format($grand_total, 2) }}</td>
                </tr>
                @else
                    <tr>
                        <td colspan="12" class="text-center danger">No data found!</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
