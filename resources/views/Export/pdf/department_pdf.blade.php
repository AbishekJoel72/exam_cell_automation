<!DOCTYPE html>
<html>

<head>
    <title> Department List</title>
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
    <h3>Department List</h3>
    <table>
        <thead>
            <tr>
                <th>S.NO</th>
                <th>Department Code</th>
                <th>Department Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $key => $d)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $d->department_code }}</td>
                    <td>{{ $d->department_name }}</td>
                    <td>{{ $d->status == 1 ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
