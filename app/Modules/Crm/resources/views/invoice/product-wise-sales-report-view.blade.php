<div class="btn-group" role="group" aria-label="Basic example">
    <a href="#" class="btn btn-icon btn-secondary" onclick="printDiv('printableArea')"><i class="fa fa-print"></i>
        Print</a>
</div>
<div class="row" id="printableArea">
    <div class="col-12">
        <h2 class="text-center">Product Wise Sales Report From {{  date("F jS, Y", strtotime($start_date)) }}
            TO {{  date("F jS, Y", strtotime($end_date)) }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Date</th>
                    <th>Product Name</th>
                    <th class="text-center">Quantity</th>
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
                        <td>{{ isset($dt->name)?$dt->name:"N/A" }}</td>
                        <td class="text-center">{{ $dt->qty }}</td>
                        <td class="text-right">{{ number_format($dt->amount, 2) }}</td>
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
