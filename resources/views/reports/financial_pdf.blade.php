<!DOCTYPE html>
<html>
<head>
    <title>Financial Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Financial Report: Fee Collection</h2>
    <p>Period: {{ $startDate }} to {{ $endDate }}</p>
    <p>Total Collection: ${{ number_format($totalCollection, 2) }}</p>
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Student</th>
                <th>Class</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Method</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->feeInvoice->student->first_name ?? 'N/A' }} {{ $payment->feeInvoice->student->last_name ?? '' }}</td>
                    <td>{{ $payment->feeInvoice->student->schoolClass->name ?? 'N/A' }}</td>
                    <td>${{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ ucfirst($payment->payment_method) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>