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
        h2,h4{
            margin: 0;
            padding: 0,
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
       
    </style>
</head>

<body>
    <h2>Sales History</h2>
    <h4>{{ $pump->name }} - {{ $pump->location }}</h4>
    <table>
        <thead>
            <tr>
                <th class="min-w-150px">Id</th>
                <th class="min-w-150px">Date</th>
                <th class="min-w-150px">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->date }}</td>
                    <td>{{ $order->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
