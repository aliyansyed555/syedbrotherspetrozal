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
        table, th, td {
            border: 1px solid black;
        }
        th, td {
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
    <h2>{{ $pump->name }} - {{ $pump->location }}</h2>
    @include('client_admin.pump._reports_table')
</body>
</html>
