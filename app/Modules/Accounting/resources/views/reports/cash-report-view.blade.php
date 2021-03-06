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
    <div class="col-12 col-lg-9 col-sm-12 col-xl-9 col-md-9">
        <h2 class="text-center">
            Profit and Loss Report Upto {{  date("F jS, Y", strtotime($date)) }}
        </h2>
        <div class="table-responsive ">
            <table class="table table-hover table-xs">
                <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance</th>
                </tr>
                </thead>
                <?php
                $debit = 0;
                $credit = 0;
                $balance = 0;
                ?>
                <tbody>
                <tr>
                    <td>{{$date}}</td>
                    <td>Opening Balance</td>
                    @if($openingBalance<0)
                        <?php
                        $debit += abs($openingBalance);
                        $balance = ($credit - $debit);
                        ?>
                        <td>{{ number_format(abs($openingBalance), 2) }}</td>
                        <td></td>
                        <td>{{ number_format($balance, 2) }}</td>
                    @else
                        <?php
                        $credit += $openingBalance;
                        $balance = ($credit - $debit);
                        ?>
                        <td></td>
                        <td>{{ number_format($openingBalance, 2) }}</td>
                        <td>{{ number_format($balance, 2) }}</td>
                    @endif
                </tr>


                @if($moneyReceipts)
                    @foreach($moneyReceipts as $moneyReceipt)
                        <?php
                        $credit += $moneyReceipt->amount;
                        $balance = ($credit - $debit);
                        ?>
                        <tr>
                            <td>{{$moneyReceipt->date}}</td>
                            <td>{{$moneyReceipt->mr_no}}</td>
                            <td>{{ number_format($moneyReceipt->amount, 2) }}</td>
                            <td></td>
                            <td>{{ number_format($balance, 2) }}</td>
                        </tr>
                    @endforeach
                @endif



                @if($expenses)
                    @foreach($expenses as $expense)
                        <?php
                        $debit += $expense->amount;
                        $balance = ($credit - $debit);
                        ?>
                        <tr>
                            <td>{{$expense->date}}</td>
                            <td>{{$expense->voucher_no}} ( {{$expense->name }} )</td>
                            <td>{{ number_format($expense->amount, 2) }}</td>
                            <td></td>
                            <td>{{ number_format($balance, 2) }}</td>
                        </tr>
                    @endforeach
                @endif



                @if($payments)
                    @foreach($payments as $payment)
                        <?php
                        $debit += $payment->amount;
                        $balance = ($credit - $debit);
                        ?>
                        <tr>
                            <td>{{$payment->date}}</td>
                            <td>{{$payment->pr_no}}</td>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                            <td></td>
                            <td>{{ number_format($balance, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
                <thead class="thead-dark">
                <tr>
                    <th colspan="2">NET Balance</th>
                    <th>{{ number_format($debit, 2) }}</th>
                    <th>{{ number_format($credit, 2) }}</th>
                    <th>{{ number_format($balance, 2) }}</th>

                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
