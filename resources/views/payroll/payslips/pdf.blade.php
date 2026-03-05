<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip {{ $payslip->payslip_no }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .box { border: 1px solid #000; padding: 8px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
    </style>
    </head>
<body>
    <div class="header">
        <div>
            <div class="bold">Payslip</div>
            <div>No: {{ $payslip->payslip_no }}</div>
            <div>Month: {{ date('Y-m', strtotime($payslip->pay_month)) }}</div>
        </div>
        <div>
            <div class="bold">{{ $payslip->teacher->first_name }} {{ $payslip->teacher->last_name }}</div>
        </div>
    </div>

    <div class="box">
        <div class="bold">Earnings</div>
        <table>
            <thead>
            <tr><th>Name</th><th class="right">Amount</th></tr>
            </thead>
            <tbody>
            <tr><td>Basic Salary</td><td class="right">{{ number_format($payslip->basic_salary, 2) }}</td></tr>
            @foreach($payslip->items->where('type','allowance') as $item)
                <tr><td>{{ $item->name }}</td><td class="right">{{ number_format($item->amount, 2) }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="box">
        <div class="bold">Deductions</div>
        <table>
            <thead>
            <tr><th>Name</th><th class="right">Amount</th></tr>
            </thead>
            <tbody>
            @forelse($payslip->items->where('type','deduction') as $item)
                <tr><td>{{ $item->name }}</td><td class="right">{{ number_format($item->amount, 2) }}</td></tr>
            @empty
                <tr><td colspan="2">No deductions</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <table>
        <tr><td>Total Allowances</td><td class="right">{{ number_format($payslip->total_allowances, 2) }}</td></tr>
        <tr><td>Total Deductions</td><td class="right">{{ number_format($payslip->total_deductions, 2) }}</td></tr>
        <tr><td class="bold">Net Salary</td><td class="right bold">{{ number_format($payslip->net_salary, 2) }}</td></tr>
    </table>
</body>
</html>
