<div class="col-12">
    <h4 class="form-section"><i class="ft-airplay"></i> Employee List</h4>
    <div class="card">
        <div class="card-content">
            <div class="row table-responsive">
                <table class="table table-de mb-0 table-sm table-bordered table-hover " id="table-data-list">
                    <thead class="table-inverse ">
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Basic Amnt.</th>
                        <th>Home Allow.</th>
                        <th>Medical Allow.</th>
                        <th>TA</th>
                        <th>DA</th>
                        <th>Others Allow.</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 0;
                    ?>
                    @if(!$data->isEmpty())
                        @foreach($data as $key => $dt)
                            <?php
                            $model = \App\Modules\Hr\Models\SalarySetup::where('employee_id', '=', $dt->id)->where('effective_date', '=', $effective_date)->first();
                            if (!$model){
                            $count++;
                            ?>
                            <tr class="cartList">
                                <th scope="row" class="count">{{ ++$key }}</th>
                                <td>
                                    {{ $dt->full_name }}
                                    <input type="hidden" name="salary[employee_id][]"
                                           class="form-control employee_id"
                                           value="{{ $dt->id }}">
                                </td>
                                <td class="text-center">
                                    {{ $dt->department->name }}
                                </td>
                                <td class="text-center">
                                    {{ $dt->designation->name }}
                                </td>
                                <td class="text-center">
                                    <input type="text" name="salary[basic_amount][]" class="form-control basic_amount"
                                           onkeyup="calculate(event)">
                                </td>
                                <td>
                                    <input type="text" placeholder="" class="form-control home_allowance"
                                           name="salary[home_allowance][]" onkeyup="calculate(event)">
                                </td>
                                <td>
                                    <input type="text" class="form-control medical_allowance"
                                           name="salary[medical_allowance][]" onkeyup="calculate(event)">
                                </td>
                                <td>
                                    <input type="text" class="form-control ta"
                                           name="salary[ta][]" onkeyup="calculate(event)">
                                </td>
                                <td>
                                    <input type="text" class="form-control da"
                                           name="salary[da][]" onkeyup="calculate(event)">
                                </td>
                                <td>
                                    <input type="text" class="form-control other_allowances"
                                           name="salary[other_allowances][]" onkeyup="calculate(event)">
                                </td>
                                <td>
                                    <span class="row-total-text"></span>
                                    <input type="hidden" class="form-control total_salary"
                                           name="salary[total_salary][]" readonly>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        @endforeach
                    @endif
                    @if($count == 0)
                        <tr>
                            <td colspan="11" class="text-danger text-center">No result found!</td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="form-actions right">
        <a type="button" class="btn btn-warning mr-1" href="{{ route('hr.salary.create') }}">
            <i class="ft-refresh-ccw"></i> Reload
        </a>
        <button type="submit" class="btn btn-primary" name="saveInvoice" id="saveInvoice">
            <i class="fa fa-check-square-o"></i> Save
        </button>
    </div>
</div>

<script>
    // Restricts input for the set of matched elements to the given inputFilter function.
    $(document).on('input keyup  drop paste', ".basic_amount, .home_allowance, .medical_allowance, .ta, .da, .other_allowances, .total_salary", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });

    function calculate(e) {
        var serial = 1;
        $("#table-data-list tbody tr.cartList th.count ").each(function (index, element) {
                console.log("CALCULATION STARTED::" + index);
                serial++;
                var temp_basic_amount = nanCheck(parseFloat($(this).closest('tr').find(".basic_amount").val()));
                var temp_home_allowance = nanCheck(parseFloat($(this).closest('tr').find(".home_allowance").val()));
                var temp_medical_allowance = nanCheck(parseFloat($(this).closest('tr').find(".medical_allowance").val()));
                var temp_ta = nanCheck(parseFloat($(this).closest('tr').find(".ta").val()));
                var temp_da = nanCheck(parseFloat($(this).closest('tr').find(".da").val()));
                var temp_other_allowances = nanCheck(parseFloat($(this).closest('tr').find(".other_allowances").val()));
                var row_total = temp_basic_amount + temp_home_allowance + temp_medical_allowance + temp_ta + temp_da + temp_other_allowances;
                console.log("temp_basic_amount:" + typeof temp_basic_amount);
                console.log("row_total:" + row_total);
                if (row_total > 0) {
                    $(this).closest('tr').find(".total_salary").val(row_total.toFixed(2));
                    $(this).closest('tr').find(".row-total-text").html(row_total.toFixed(2));
                    console.log(row_total);
                }
            }
        );
    }
</script>
