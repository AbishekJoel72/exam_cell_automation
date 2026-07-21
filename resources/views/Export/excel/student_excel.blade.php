<!DOCTYPE html>
<html>

<head>
    <title>Student List</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Register No</th>
                <th>Roll No</th>
                <th>Student Name</th>
                <th>Department</th>
                <th>Course</th>
                <th>Room No</th>
                <th>Academic Year</th>
                <th>Current Year</th>
                <th>Semester</th>
                <th>Section</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($student as $key => $s)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $s->register_no }}</td>
                    <td>{{ $s->roll_no }}</td>
                    <td>{{ $s->first_name }} - {{ $s->last_name }}</td>
                    <td>{{ $s->get_department->department_code }} - {{ $s->get_department->department_name }}</td>
                    <td>{{ $s->get_course->course_code }} - {{ $s->get_course->course_name }}</td>
                    <td>{{ $s->get_classroom->room_no }} </td>
                    <td>{{ $s->academic_year }}</td>
                    <td>{{ $s->current_year }}</td>
                    <td>{{ $s->semester }}</td>
                    <td>{{ $s->section }}</td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->phone }}</td>
                    <td>{{ $s->status == 1 ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
