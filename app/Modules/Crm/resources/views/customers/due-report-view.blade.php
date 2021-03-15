<div class="row">
    <div class="col-12">
        <h2 class="text-center">
            Customer Due Report Upto {{  date("F jS, Y", strtotime($date)) }}
        </h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Store</th>
                    <th>Customer</th>
                    <th class="text-center">Customer Code</th>
                    <th class="text-center">Invoice Amount</th>
                    <th class="text-center">Return Amount</th>
                    <th class="text-center">MR Amount</th>
                    <th>Due Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $grand_total = $invoice_total = $return_total = $mr_total = $due_total = 0;
                $sl = 1;
                ?>
                @foreach($data as $key => $dt)
                    <?php
                    $invoice_amount = \App\Modules\Crm\Models\Invoice::totalInvoiceAmountOfCustomerUpTo($date, $dt->id);
                    $invoice_return_amount = \App\Modules\Crm\Models\InvoiceReturn::totalInvoiceReturnAmountOfCustomerUpTo($date, $dt->id);
                    $invoice_mr_amount = \App\Modules\Accounting\Models\MoneyReceipt::totalInvoiceReturnAmountOfCustomerUpTo($date, $dt->id);

                    $due = $invoice_amount - ($invoice_return_amount + $invoice_mr_amount);
                    if ($due > 0){

                    $invoice_total += $invoice_amount;
                    $return_total += $invoice_return_amount;
                    $mr_total += $invoice_mr_amount;
                    $due_total += $due;

                    ?>
                    <tr>
                        <th scope="row" class="text-center">{{ $sl++ }}</th>
                        <td>{{ $dt->store->name }}</td>
                        <td>{{ $dt->name }}</td>
                        <td class="text-right">{{ $dt->code }}</td>
                        <td class="text-center">{{ number_format($invoice_amount, 2) }}</td>
                        <td class="text-right">{{ number_format($invoice_return_amount, 2) }}</td>
                        <td class="text-right">{{ number_format($invoice_mr_amount, 2) }}</td>
                        <td class="text-right">{{ number_format($due, 2) }}</td>
                    </tr>
                    <?php
                    }
                    ?>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right">GRAND TOTAL</td>
                    <td class="text-center">{{ number_format($invoice_total, 2) }}</td>
                    <td class="text-right">{{ number_format($return_total, 2) }}</td>
                    <td class="text-right">{{ number_format($mr_total, 2) }}</td>
                    <td class="text-right">{{ number_format($due_total, 2) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
