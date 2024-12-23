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
        h2, h4{
            margin: 0px;
            padding: 0px;
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
    @if ($report_type == "daily_report")
        <h2>Daily Report</h2>
    @else
        <h2>Bank Transfers</h2>
    @endif

    <h4 style="margin-bottom: 10px">{{ $pump->name }} - {{ $pump->location }}</h4>
    <table>
        @if ($report_type == "daily_report")
            <thead>
                <tr>
                    <th class="min-w-150px">Date</th>
                    <th class="min-w-150px">Daily Expense</th>
                    <th class="min-w-150px">Detail</th>
                    <th class="min-w-150px">Pump Rent</th>
                    <th class="min-w-150px">Bank Deposit</th>
                    <th class="min-w-150px">Account Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daily_reports as $daily_report)
                    @if ($daily_report->bank_deposit >= 0)
                        <tr>
                            
                            <td>{{ $daily_report->date }}</td>
                            <td>{{ $daily_report->daily_expense }}</td>
                            <td>{{ $daily_report->expense_detail }}</td>
                            <td>{{ $daily_report->pump_rent }}</td>
                            <td>{{ $daily_report->bank_deposit }}</td>
                            <td>{{ $daily_report->account_number }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        @else
            <thead>
                <tr>
                    <th class="min-w-150px">Date</th>
                    <th class="min-w-150px">Bank Deposit</th>
                    <th class="min-w-150px">Account Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daily_reports as $daily_report)
                    @if ($daily_report->bank_deposit < 0)
                        <tr>
                            <td>{{ $daily_report->date }}</td>
                            <td>{{ $daily_report->bank_deposit }}</td>
                            <td>{{ $daily_report->account_number }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>

        @endif

    </table>
</body>

</html>
