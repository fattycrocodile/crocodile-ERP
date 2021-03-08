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
            Expense Report From {{  date("F jS, Y", strtotime($start_date)) }} To {{  date("F jS, Y", strtotime($end_date)) }}
        </h2>
        <div class="table-responsive ">
            <table class="table table-hover table-xs">
                <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>Voucher No</th>
                    <th>Pay to</th>
                    <th>Expense Type</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <?php
                $total = 0;
                ?>
                <tbody>
                @if(count($expenses)>0)
                    @foreach($expenses as $expense)
                        <?php
                        $total += $expense->amount;
                        ?>
                        <tr>
                            <td>{{$expense->date}}</td>
                            <td>{{$expense->voucher_no}}</td>
                            <td>{{$expense->reference}}</td>
                            <td>{{ $expense->name }}</td>
                            <td>{{ number_format($expense->amount, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="5" class="text-center"><b>Data Not Found</b></td></tr>
                @endif
                </tbody>
                <thead class="thead-dark">
                <tr>
                    <th colspan="4">NET EXPENSE</th>
                    <th>{{ number_format($total, 2) }}</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
