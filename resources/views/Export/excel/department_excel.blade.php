<!DOCTYPE html>
<html>

<head>
    <title>Department List</title>
</head>

<body>
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
