<div class="col-12">
    <div class="card">
        <div class="card-content">
            <div class="table-responsive">
                <table class="table table-de mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice Date</th>
                        <th>Invoice No</th>
                        <th>Invoice Amount</th>
                        <th>Due Amount</th>
                        <th>Payment Amount</th>
                        <th>Discount Amount</th>
                        <th>Remaining Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!$data->isEmpty())
                        @foreach($data as $key => $dt)
                            <?php
                            $due_amount = \App\Modules\Accounting\Models\MoneyReceipt::totalMrAmountOfInvoice($dt->invoice_id);
                            ?>
                            <tr>
                                <th scope="row">{{ ++$key }}</th>
                                <td>{{ $dt->date }}</td>
                                <td>{{ $dt->invoice_no }}</td>
                                <td class="text-center">{{ number_format($dt->grand_total, 2) }}</td>
                                <td class="text-center">{{ number_format($due_amount) }}</td>
                                <td><input type="text" placeholder="0" class="form-control payment-amount"
                                           name="mr[payment_amount][]" max="{{$due_amount}}"></td>
                                <td><input type="text" placeholder="0" class="form-control discount-amount"
                                           name="mr[discount_amount][]" max="{{$due_amount}}"></td>
                                <td class="text-center">{{$due_amount}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-danger text-center">No result found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
