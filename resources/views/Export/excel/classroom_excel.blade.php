<!DOCTYPE html>
<html>

<head>
    <title>Subject List</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>S.NO</th>
                <th>Room No</th>
                <th>Building</th>
                <th>Floor</th>
                <th>Total Seats</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classroom as $key => $c)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $c->room_no }}</td>
                    <td>{{ $c->building }}</td>
                    <td>{{ $c->floor }}</td>
                    <td>{{ $c->total_seats }}</td>
                    <td>{{ $c->status == 1 ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
