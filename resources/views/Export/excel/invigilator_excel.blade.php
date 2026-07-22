<!DOCTYPE html>
<html>

<head>
    <title>Invigilator Allocation List</title>
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
                <th>Staff Code</th>
                <th>Faculties Name</th>
                <th>Room No</th>
                <th>Building</th>
                <th>Floor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invigilatorAllocation as $key => $i)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $i->get_exams_details->exam_name }}</td>
                    <td>{{ $i->get_exams_details->get_department->department_code }} -
                        {{ $i->get_exams_details->get_department->department_name }}</td>
                    <td>{{ Carbon::parse($i->get_exams_details->exam_date)->format('d-m-Y') }}</td>
                    <td>{{ $i->get_staff->staff_code }} </td>
                    <td>{{ $i->get_staff->first_name }} - {{ $i->get_staff->last_name }}</td>
                    <td>{{ $i->get_classroom->room_no }}</td>
                    <td>{{ $i->get_classroom->building }}</td>
                    <td>{{ $i->get_classroom->floor }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
