<!DOCTYPE html>
<html>

<head>
    <title> Faculties List</title>
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
    <h3>Faculties List</h3>
    <table>
   <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Staff Code </th>
                <th>Faculty Name </th>
                <th>Department</th>
                <th>Designation</th>
                <th>Qualification</th>
                <th>Experience</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($faculties as $key => $f)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $f->staff_code }}</td>
                    <td>{{ $f->first_name }} - {{ $f->last_name }}</td>
                    <td>{{ $f->get_department->department_code }} - {{ $f->get_department->department_name }}</td>
                    <td>{{ $f->designation }}</td>
                    <td>{{ $f->qualification }}</td>
                    <td>{{ $f->experience }}</td>
                    <td>{{ $f->email }}</td>
                    <td>{{ $f->phone }}</td>
                    <td>{{ $f->status == 1 ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
