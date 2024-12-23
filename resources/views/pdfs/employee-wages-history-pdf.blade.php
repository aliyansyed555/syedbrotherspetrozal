<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reports</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 0px 3px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .bg-success {
            background-color: #d4edda;
            color: #155724;
        }

        .bg-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <h2>{{ $employee->name }} - {{ $employee->phone }}</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount Received</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wages as $wage)
                <tr>
                    <td>{{ $wage->date }}</td>
                    <td>{{ $wage->amount_received }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
