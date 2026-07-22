<!DOCTYPE html>
<html>

<head>
    <title>Seat Allocation List</title>
</head>

<body>
    @php
        use Carbon\Carbon;
    @endphp
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Exam Name</th>
                <th>Department</th>
                <th>Exam Date</th>
                <th>Register No</th>
                <th>Student Name</th>
                <th>Room No</th>
                <th>Seat No</th>
                <th>Row No</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($seatAllocation as $key => $s)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $s->get_exams_details->exam_name }}</td>
                    <td>{{ $s->get_exams_details->get_department->department_code }} -
                         {{ $s->get_exams_details->get_department->department_name }}</td>
                    <td>{{ Carbon::parse($s->get_exams_details->exam_date)->format('d-m-Y') }}</td>
                    <td>{{ $s->get_student->register_no }}</td>
                    <td>{{ $s->get_student->first_name }} {{ $s->get_student->last_name }}</td>
                    <td>{{ $s->get_classroom->room_no }}</td>
                    <td>{{ $s->seat_no }}</td>
                    <td>{{ $s->row_no }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
