<div class="col-12">
    <h4 class="form-section"><i class="ft-airplay"></i> Invoice Info</h4>
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text"
                               class="form-control @error('date') is-invalid @enderror"
                               id="date" value="{!! date('Y-m-d') !!}" name="date" required>
                        @error('date')
                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                    </div>
                </div>
                <div class="col-md-2 cash_payment">
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select id="payment_method" name="payment_method"
                                class="select2 form-control @error('payment_method') is-invalid @enderror">
                            <option value="" selected="">Select Payment method</option>
                            @foreach($payment_type as $key => $value)
                                <option value="{{ $key }}"> {{ $value }} </option>
                            @endforeach
                        </select>
                        @error('payment_method')
                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                    </div>
                </div>

                <div class="col-md-2 bank_other_payment">
                    <div class="form-group">
                        <label for="bank_id">Bank</label>
                        <select id="bank_id" name="bank_id"
                                class="select2 form-control @error('bank_id') is-invalid @enderror">
                            <option value="none" selected="">Select Bank</option>
                            @foreach($bank as $key => $bnk)
                                <option value="{{ $key }}"> {{ $bnk }} </option>
                            @endforeach
                        </select>
                        @error('bank_id')
                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                    </div>
                </div>

                <div class="col-md-2 bank_other_payment">
                    <div class="form-group">
                        <label for="cheque_no">Cheque/Transaction No</label>
                        <input type="text"
                               class="form-control @error('cheque_no') is-invalid @enderror"
                               id="cheque_no" name="cheque_no">
                        @error('cheque_no')
                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                    </div>
                </div>
                <div class="col-md-2 bank_other_payment">
                    <div class="form-group">
                        <label for="cheque_date">Cheque Date</label>
                        <input type="text"
                               class="form-control @error('cheque_date') is-invalid @enderror"
                               id="cheque_date" name="cheque_date">
                        @error('cheque_date')
                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                    </div>
                </div>
                <div class="col-md-2 cash_payment">
                    <div class="form-group">
                        <label for="manual_mr_no">Manual MR No</label>
                        <input type="text"
                               class="form-control @error('mr_no') is-invalid @enderror"
                               id="manual_mr_no" name="manual_mr_no">
                        @error('manual_mr_no')
                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                    </div>
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-de mb-0" id="table-data-list">
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
                    <?php
                    $totalBill = $totalDue = 0;
                    $count = 0;
                    ?>
                    @if(!$data->isEmpty())
                        @foreach($data as $key => $dt)
                            <?php
                            $mrAmount = \App\Modules\Accounting\Models\MoneyReceipt::totalMrAmountOfInvoice($dt->id);
                            $returnAmount = \App\Modules\Crm\Models\InvoiceReturn::totalReturnAmountOfInvoice($dt->id);
                            $totalMrWithReturn = $mrAmount + $returnAmount;
                            $due_amount = $dt->grand_total - $totalMrWithReturn;
                            $totalBill += $dt->grand_total;
                            $totalDue += $due_amount;
                            ?>
                            @if ($due_amount > 0)
                                <?php
                                $count++;
                                ?>
                                <tr class="cartList">
                                    <th scope="row" class="count">{{ ++$key }}</th>
                                    <td>{{ $dt->date }}</td>
                                    <td>
                                        <input type="hidden" name="mr[invoice_id][]" class="form-control invoice_id"
                                               value="{{ $dt->id }}">
                                        <span class="invoice-no">{{ $dt->invoice_no }}</span>
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="mr[invoice_total][]"
                                               class="form-control invoice_total"
                                               value="{{ $dt->grand_total }}">
                                        {{ number_format($dt->grand_total, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="mr[invoice_due][]" class="form-control invoice_due"
                                               value="{{ $due_amount }}">
                                        {{ number_format($due_amount,2) }}
                                    </td>
                                    <td>
                                        <input type="text" placeholder="0" class="form-control payment-amount"
                                               name="mr[payment_amount][]" max="{{$due_amount}}"
                                               onkeyup="calculate(event)">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="0" class="form-control discount-amount"
                                               name="mr[discount_amount][]" max="{{$due_amount}}"
                                               onkeyup="calculate(event)">
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="mr[row_due][]" class="form-control row_due"
                                               value="{{ $due_amount }}">
                                        <span class="row_due_txt">{{number_format($due_amount, 2)}}</span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-danger text-center">No result found</td>
                        </tr>
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: right;">
                        </th>
                        <th>
                            <div class="grand_total_bill_txt"
                                 style="text-align: center;">{{ number_format($totalBill, 2) }}</div>
                        </th>
                        <th>
                            <div class="grand_total_disc_txt"
                                 style="text-align: center;">{{ number_format($totalDue, 2) }}</div>
                        </th>
                        <th style="text-align: center;">
                            <span class="grand_total_payment_txt"
                                  style="text-align: center; ">{{ number_format(0, 2) }}</span>
                        </th>
                        <th style="text-align: center;">
                            <span class="grand_total_discount_txt"
                                  style="text-align: center; ">{{ number_format(0, 2) }}</span>
                        </th>
                        <th>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="5" style="text-align: right;">Grand Total
                        </th>
                        <th colspan="2" style="text-align: center;">
                            <span class="grand_total_payment_disc_txt" style="text-align: center; color: green;"></span>
                            <input type="hidden" name="grand_total" class="form-control grand_total" id="grand_total">
                        </th>
                        <th>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="form-actions right">
        <button type="button" class="btn btn-warning mr-1">
            <i class="ft-refresh-ccw"></i> Reload
        </button>
        <button type="submit" class="btn btn-primary" name="saveInvoice" id="saveInvoice">
            <i class="fa fa-check-square-o"></i> Save
        </button>
    </div>
    <!-- Modal -->
    <div class="modal fade text-left" id="xlarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">Voucher</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-primary">Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#date").datepicker({
            // appendText:"(yy-mm-dd)",
            dateFormat: "yy-mm-dd",
            altField: "#datepicker",
            altFormat: "DD, d MM, yy",
            prevText: "click for previous months",
            nextText: "click for next months",
            showOtherMonths: true,
            selectOtherMonths: true,
            maxDate: new Date()
        });
    });
    $(function () {
        $("#cheque_date").datepicker({
            // appendText:"(yy-mm-dd)",
            dateFormat: "yy-mm-dd",
            altField: "#datepicker",
            altFormat: "DD, d MM, yy",
            prevText: "click for previous months",
            nextText: "click for next months",
            showOtherMonths: true,
            selectOtherMonths: true,
            // maxDate: new Date()
        });
    });
    $("#payment_method").change(function () {
        var val = nanCheck(parseInt(this.value));
        if (isValidCode(val, cashArray)) {
            $(".bank_other_payment").hide();
        } else if (isValidCode(val, bankArray)) {
            $(".bank_other_payment").show();
        } else {
            $(".bank_other_payment").hide();
        }
    });

    // Restricts input for the set of matched elements to the given inputFilter function.
    $(document).on('input keyup  drop paste', ".payment-amount, .discount-amount", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });


    function calculate(e) {
        var serial = 1;
        var discount_total = 0;
        var payment_total = 0;
        var grand_total = 0;
        $("#table-data-list tbody tr.cartList th.count ").each(function (index, element) {
                console.log("CALCULATION STARTED::" + index);
                serial++;
                var temp_invoice_no = $(this).closest('tr').find(".invoice-no").html();
                var temp_invoice_due = nanCheck(parseFloat($(this).closest('tr').find(".invoice_due").val()));
                var temp_payment_amount = nanCheck(parseFloat($(this).closest('tr').find(".payment-amount").val()));
                var temp_discount_amount = nanCheck(parseFloat($(this).closest('tr').find(".discount-amount").val()));
                var total_payment = temp_payment_amount + temp_discount_amount;
                var row_due = temp_invoice_due - total_payment;
                if (total_payment > temp_invoice_due) {
                    $(this).closest('tr').find(".payment-amount").val('');
                    $(this).closest('tr').find(".discount-amount").val('');
                    toastr.warning("Total Due Of The invoice (" + temp_invoice_no + ") is : " + temp_invoice_due, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                } else {
                    payment_total += temp_payment_amount;
                    discount_total += temp_discount_amount;
                    grand_total += total_payment;

                    $(this).closest('tr').find(".row_due").val(row_due.toFixed(2));
                    $(this).closest('tr').find(".row_due_txt").html(row_due.toFixed(2));
                }
            }
        );
        $(".grand_total_payment_txt").html(payment_total.toFixed(2));
        $(".grand_total_discount_txt").html(discount_total.toFixed(2));
        $(".grand_total_payment_disc_txt").html(grand_total.toFixed(2));
        $("#grand_total").val(grand_total.toFixed(2));
    }
</script>
