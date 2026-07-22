<!DOCTYPE html>
<html>

<head>
    <title> Exams List</title>
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
    @php
        use Carbon\Carbon;
    @endphp
    <h3>Exams List</h3>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Department</th>
                <th>Exam Name</th>
                <th>Exam Type</th>
                <th>Exam Cycle</th>
                <th>Exam Date</th>
                <th>State Time</th>
                <th>End Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($exams as $key => $e)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $e->get_department->department_code }} - {{ $e->get_department->department_name }}</td>
                    <td>{{ $e->exam_name }} </td>
                    <td>{{ $e->exam_type }}</td>
                    <td>{{ $e->exam_cycle }}</td>
                    <td>{{ Carbon::parse($e->exam_date)->format('d-m-Y') }}</td>
                    <td>{{ Carbon::parse($e->start_time)->format('h:i A') }}</td>
                    <td>{{ Carbon::parse($e->end_time)->format('h:i A') }}</td>
                    <td>{{ $e->status == 1 ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
