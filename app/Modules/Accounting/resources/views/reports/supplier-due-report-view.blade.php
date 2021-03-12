<div class="row">
    <div class="col-12">
        <h2 class="text-center">Supplier Report Upto {{  date("F jS, Y", strtotime($date)) }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Supplier Name</th>
                    <th class="text-center">Purchase Amount</th>
                    <th class="text-center">Return Amount</th>
                    <th class="text-center">Payment Amount</th>
                    <th>Due Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $grand_total = $purchase_total = $return_total = $payment_total = $due_total = 0;
                $count = 0;
                ?>
                @foreach($data as $dt)
                    <?php
                    $purchase_amount = \App\Modules\Commercial\Models\Purchase::totalPurchaseAmountOfSupplierUpTo($date,$dt->id);
                    $purchase_return_amount = \App\Modules\StoreInventory\Models\PurchaseReturn::totalPurchaseReturnAmountOfSupplierUpTo($date,$dt->id);
                    $purchase_payment_amount = \App\Modules\Accounting\Models\SuppliersPayment::totalPurchasePaymentAmountOfSupplierUpTo($date,$dt->id);
                    $due = $purchase_amount - ($purchase_return_amount + $purchase_payment_amount);
                    if ($due > 0) {

                        $purchase_total += $purchase_amount;
                        $return_total += $purchase_return_amount;
                        $payment_total += $purchase_payment_amount;
                        $due_total += $due;
                    }
                    $count++;
                    ?>
                    <tr>
                        <th scope="row" class="text-center">{{ $count }}</th>
                        <td>{{ $dt->name }}</td>
                        <td class="text-center">{{ number_format($purchase_amount,2) }}</td>
                        <td class="text-center">{{ number_format($purchase_return_amount,2) }}</td>
                        <td class="text-center">{{ number_format($purchase_payment_amount,2) }}</td>
                        <td class="text-right">{{ number_format($due, 2) }}</td>
                    </tr>
                @endforeach
                @if($count > 0)
                    <tr>
                        <td colspan="2" class="text-right">GRAND TOTAL</td>
                        <td class="text-center">{{ number_format($purchase_total,2) }}</td>
                        <td class="text-center">{{ number_format($return_total,2) }}</td>
                        <td class="text-center">{{ number_format($payment_total,2) }}</td>
                        <td class="text-right">{{ number_format($due_total, 2) }}</td>
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
