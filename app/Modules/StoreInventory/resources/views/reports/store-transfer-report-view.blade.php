<div class="row">
    <div class="col-12">
        <h2 class="text-center">Store Transfer Report From {{  date("F jS, Y", strtotime($start_date)) }}
            TO {{  date("F jS, Y", strtotime($end_date)) }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Send Store</th>
                    <th class="text-center">Receive Store</th>
                    <th class="text-center">Product Name</th>
                    <th class="text-center">Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $dt)
                    <tr>
                        <th scope="row" class="text-center">{{ ++$key }}</th>
                        <td>{{ $dt->date }}</td>
                        <td>{{ $dt->send_sore }}</td>
                        <td class="text-center">{{ $dt->receive_store }}</td>
                        <td class="text-center">{{ $dt->product }}</td>
                        <td class="text-center">{{ number_format($dt->qty,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
