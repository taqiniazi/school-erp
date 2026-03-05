<!DOCTYPE html>
<html>
<head>
    <title>HR Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>HR Report: Staff List</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $person)
                <tr>
                    <td>{{ $person->first_name }} {{ $person->last_name }}</td>
                    <td>{{ $person->department }}</td>
                    <td>{{ $person->designation }}</td>
                    <td>{{ $person->phone }}</td>
                    <td>{{ $person->email }}</td>
                    <td>{{ ucfirst($person->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>