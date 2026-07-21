<!DOCTYPE html>
<html>

<head>
    <title> Course List</title>
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
    <h3>Course List</h3>
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
