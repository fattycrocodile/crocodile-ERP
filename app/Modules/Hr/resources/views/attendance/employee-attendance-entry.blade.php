<div class="col-12">
    <h4 class="form-section"><i class="ft-airplay"></i> Employee List</h4>
    <div class="card">
        <div class="card-content">
            <div class="row table-responsive">
                <table class="table table-de mb-0" id="table-data-list">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>In-time</th>
                        <th>Out-time</th>
                        <th>Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!$data->isEmpty())
                        @foreach($data as $key => $dt)
                            <?php
                            $model = \App\Modules\Hr\Models\Attendance::where('employee_id', '=', $dt->id)->where('date', '=', $date)->first();
                            $in_time = $model ? $model->in_time : "";
                            $out_time = $model ? $model->out_time : "";
                            ?>
                            <tr class="cartList">
                                <th scope="row" class="count">{{ ++$key }}</th>
                                <td>
                                    {{ $dt->full_name }}
                                    <input type="hidden" name="attendance[employee_id][]"
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
                                    <input type="time" name="attendance[in_time][]" class="form-control out-time"
                                           placeholder="09:00"
                                           value="<?= $in_time ?>">
                                </td>
                                <td>
                                    <input type="time" placeholder="18:00" class="form-control out-time"
                                           name="attendance[out_time][]"
                                           value="<?= $out_time ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control remarks"
                                           name="attendance[remarks][]">
                                </td>
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
<div class="col-12">
    <div class="form-actions right">
        <a type="button" class="btn btn-warning mr-1" href="{{ route('hr.attendance.create') }}">
            <i class="ft-refresh-ccw"></i> Reload
        </a>
        <button type="submit" class="btn btn-primary" name="saveInvoice" id="saveInvoice">
            <i class="fa fa-check-square-o"></i> Save
        </button>
    </div>
</div>

<script>
    // Restricts input for the set of matched elements to the given inputFilter function.
    $(document).on('input keyup  drop paste', ".payment-amount, .discount-amount", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });
</script>
