<div class="row">
    <div class="col-12">
        <h2 class="text-center">Employees Report</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <th class="text-center;">#</th>
                    <th>Full Name</th>
                    <th>Birth Date</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Contact no</th>
                    <th>Gender</th>
                    <th>Religion</th>
                    <th>Marital Status</th>
                    <th>Join Date</th>
                    <th>Appointment Date</th>
                    <th>TIN Date</th>
                    <th>Present Address</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @if(!$data->isEmpty())
                    @foreach($data as $key => $dt)
                        <tr>
                            <th scope="row" class="text-center">{{ ++$key }}</th>
                            <td>{{ $dt->full_name }}</td>
                            <td>{{ $dt->dob }}</td>
                            <td>{{ $dt->department->name }}</td>
                            <td>{{ $dt->designation->name }}</td>
                            <td>{{ $dt->contact_no }}</td>
                            <td>{{ \App\Modules\Config\Models\Lookup::item('gender', $dt->gender) }}</td>
                            <td>{{ \App\Modules\Config\Models\Lookup::item('religion', $dt->religion) }}</td>
                            <td>{{ \App\Modules\Config\Models\Lookup::item('marital_status', $dt->marital_status) }}</td>
                            <td>{{ $dt->join_date }}</td>
                            <td>{{ $dt->appointment_date }}</td>
                            <td>{{ $dt->tin }}</td>
                            <td>{!! $dt->present_address !!}</td>
                            <td>{{ $dt->status === \App\Modules\Hr\Models\Employees::ACTIVE ? "ACTIVE" : "INACTIVE" }}</td>
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
