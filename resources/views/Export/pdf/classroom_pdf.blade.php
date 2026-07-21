<!DOCTYPE html>
<html>

<head>
    <title> Class Room List</title>
    <style>
        body {
            font-family: Arial;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <h3>Class Room  List</h3>
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
