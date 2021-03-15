<div class="row">
    <div class="col-12">
        <u><h2 class="text-center">SALARY SHEET FROM <?= $start_date ?> TO <?= $end_date ?></h2></u>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Joining Date</th>
                    {{--                    <th>Store</th>--}}
                    <th>Working Days</th>
                    <th>Att</th>
                    <th>Gross Salary</th>
                    <th>Net Payable</th>
                </tr>
                </thead>
                <tbody>
                @if(!$data->isEmpty())
                    <?php
                    $holidayArray = [];
                    ?>
                    @foreach($data as $key => $dt)
                        <tr>
                            <td>{{ $dt->full_name }}</td>
                            <td>{{ $dt->department->name }}</td>
                            <td>{{ $dt->designation->name }}</td>
                            <td>{{ $dt->join_date }}</td>
                            <?php
                            $holidayCount = $leaveCount = $presentCount = $absentCount = 0;


                            $date1=date_create("$start_date");
                            $date2=date_create("$end_date");
                            $diff=date_diff($date1,$date2);
                            //echo $diff->format("%R%a days");
                            $count = $diff->format("%a") + 1;

                            $holiday = \App\Modules\Hr\Models\HolidaySetup::totalHolidayInDateRange($start_date, $end_date);
                            $leave = 0; //todo:: amdad will calculate the leave
                            $attendance = \App\Modules\Hr\Models\Attendance::totalAttendanceOfEmployeeInDateRange($start_date, $end_date, $dt->id);
                            $attendance += $leave;
                            $salaryData = \App\Modules\Hr\Models\SalarySetup::getSalary($start_date, $dt->id);
                            $grossSalary = $salaryData['total_amount'];
                            $workingDays = $count - $holidayCount;
                            if ($grossSalary > 0) {
                                $perDaySalary = @$grossSalary / @$attendance;
                                $netPayable = $perDaySalary * $attendance;
                            } else
                                $netPayable = 0;
                            ?>
                            <td class="text-center"><?= $count; ?></td>
                            <td class="text-center"><?= $attendance; ?></td>
                            <td class="text-right"><?= $grossSalary; ?></td>
                            <td class="text-right"><?= $netPayable; ?></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="14" class="danger">Sorry! no data found in this criteria.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
