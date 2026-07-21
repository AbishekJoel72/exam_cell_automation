<!DOCTYPE html>
<html>

<head>
    <title> Subject List</title>
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
    <h3>Subject List</h3>
    <table>
        <thead>
            <tr>
                <th>S.NO</th>
                <th>Department</th>
                <th>Course</th>
                <th>Semester</th>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Credits</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjectses as $key => $s)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $s->get_department->department_code }} - {{ $s->get_department->department_name }}</td>
                    <td>{{ $s->get_courses->course_code }} - {{ $s->get_courses->course_name }}</td>
                    <td>{{ $s->semester }}</td>
                    <td>{{ $s->subject_code }}</td>
                    <td>{{ $s->subject_name }}</td>
                    <td>{{ $s->credits }}</td>
                    <td>{{ $s->status == 1 ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
