<!DOCTYPE html>
<html>

<head>
    <title>Course List</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>S.NO</th>
                <th>Department</th>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Duration</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $key => $c)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $c->get_department->department_code }} - {{ $c->get_department->department_name }}</td>
                    <td>{{ $c->course_code }}</td>
                    <td>{{ $c->course_name }}</td>
                    <td>{{ $c->duration }}</td>
                    <td>{{ $c->status == 1 ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
