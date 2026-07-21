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
