<div class="row">
    <div class="col-12">
        <h2 class="text-center">Attendance Report</h2>
        <div class="row col-md-6" style="color: green;">
            A: Absent <br>
            H: Holiday <br>
            L: Leave <br>
            P: Present <br>
        </div>
        <div class="row  col-md-6" style="color: green;">
            Present: Present + Leave
        </div>
        <div class="table-responsive">

            <table class="table table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Store</th>
                    <?php
                    $end_date = date('Y-m-d H:i:s', strtotime($end_date . ' +1 day'));

                    $begin = new DateTime($start_date);
                    $end = new DateTime($end_date);

                    $interval = DateInterval::createFromDateString('1 day');
                    $period = new DatePeriod($begin, $interval, $end);

                    foreach ($period as $dt) {
                    ?>
                    <th><?= $dt->format("M-d"); ?></th>
                    <?php
                    }
                    ?>
                    <th>Working Days</th>
                    <th>Leave</th>
                    <th>Present</th>
                </tr>
                </thead>
                <tbody>
                @if(!$data->isEmpty())
                    <?php
                    $holidayArray = [];
                    ?>
                    @foreach($data as $key => $dt)
                        <tr>
                            <th scope="row" class="text-center">{{ ++$key }}</th>
                            <td>{{ $dt->full_name }}</td>
                            <td>{{ $dt->department->name }}</td>
                            <td>{{ $dt->designation->name }}</td>
                            <td>{{ $dt->store->name }}</td>
                            <?php
                            $count = $holidayCount = $leaveCount = $presentCount = $absentCount = 0;
                            foreach ($period as $date) {
                            $newDate = $date->format("Y-m-d");
                            $count++;
                            $string = "";
                            $holiday = \App\Modules\Hr\Models\HolidaySetup::isHoliday($newDate);
                            $leave = \App\Modules\Hr\Models\LeaveApplication::findLeave($newDate, $dt->id);
                            if ($holiday == 1) // if holiday
                            {
                                $holidayCount++;
                                $string = "H";
                            } else if ($leave == 1) {
                                $leaveCount++;
                                $string = "L";
                            } else {
                                $attendance = \App\Modules\Hr\Models\Attendance::dailyAttendanceStatusOfEmployee($newDate, $dt->id);
                                if ($attendance == 1) {
                                    $presentCount++;
                                    $string = "P";
                                } else {
                                    $absentCount++;
                                    $string = "A";
                                }
                            }
                            ?>
                            <td class="text-center"><?= $string; ?></td>
                            <?php
                            }
                            $workingDays = $count - $holidayCount;
                            $presentCount += $leaveCount;
                            ?>
                            <td class="text-center"><?= $workingDays; ?></td>
                            <td class="text-center"><?= $leaveCount; ?></td>
                            <td class="text-center"><?= $presentCount; ?></td>
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
