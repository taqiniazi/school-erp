﻿<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip {{ $payslip->payslip_no }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        table { width: 100%; border-collapse: collapse; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .muted { color: #555; }
        .title { font-size: 16px; font-weight: 700; margin-bottom: 2px; }
        .subtitle { font-size: 12px; margin-bottom: 14px; }
        .info td { padding: 4px 6px; vertical-align: top; }
        .label { font-weight: 700; width: 18%; white-space: nowrap; }
        .value { width: 32%; }
        .salary th, .salary td { border: 1px solid #d9dee7; padding: 8px 10px; }
        .salary thead th { background: #2c2f33; color: #fff; font-weight: 700; }
        .salary .amount { text-align: right; white-space: nowrap; }
        .totals td { border: 1px solid #d9dee7; padding: 8px 10px; }
        .totals .label { font-weight: 700; }
    </style>
    </head>
<body>
    @php
        $teacher = $payslip->teacher;
        $user = optional($teacher)->user;
        $staffProfile = optional($teacher)->staffProfile;
        $campus = optional($teacher)->campus;
        $monthLabel = $payslip->pay_month ? $payslip->pay_month->format('F Y') : date('F Y', strtotime((string) $payslip->pay_month));

        $earnings = collect([['name' => 'Basic', 'amount' => (float) $payslip->basic_salary]])
            ->merge(
                $payslip->items
                    ->where('type', 'allowance')
                    ->values()
                    ->map(function ($item) {
                        return ['name' => $item->name, 'amount' => (float) $item->amount];
                    })
            )
            ->values();

        $deductions = $payslip->items
            ->where('type', 'deduction')
            ->values()
            ->map(function ($item) {
                return ['name' => $item->name, 'amount' => (float) $item->amount];
            })
            ->values();

        $rows = max($earnings->count(), $deductions->count());
        $totalEarnings = (float) $payslip->basic_salary + (float) $payslip->total_allowances;
        $totalDeductions = (float) $payslip->total_deductions;
    @endphp

    <table>
        <tr>
            <td style="width: 25%"></td>
            <td class="text-center" style="width: 50%">
                <div class="title">Payslip</div>
                <div class="subtitle muted">Payment slip for the month of {{ $monthLabel }}</div>
            </td>
            <td class="text-right" style="width: 25%; vertical-align: top;">
                <div class="muted">Working Branch: {{ $campus->name ?? '-' }}</div>
            </td>
        </tr>
    </table>

    <table class="info" style="margin-bottom: 14px;">
        <tr>
            <td class="label">EMP Code</td>
            <td class="value">{{ $teacher->id ?? '-' }}</td>
            <td class="label">EMP Name</td>
            <td class="value">{{ $user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">PF No.</td>
            <td class="value">{{ $staffProfile->pf_no ?? '-' }}</td>
            <td class="label">NOD</td>
            <td class="value">{{ isset($nod) && $nod !== null ? $nod : '-' }}</td>
        </tr>
        <tr>
            <td class="label">ESI No.</td>
            <td class="value">{{ $staffProfile->esi_no ?? '-' }}</td>
            <td class="label">Mode of Pay</td>
            <td class="value">{{ $staffProfile->mode_of_pay ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Designation</td>
            <td class="value">{{ $staffProfile->designation ?? '-' }}</td>
            <td class="label">Ac No.</td>
            <td class="value">{{ $staffProfile->account_no ?? '-' }}</td>
        </tr>
    </table>

    <table class="salary">
        <thead>
            <tr>
                <th style="width: 34%;">Earnings</th>
                <th style="width: 16%;" class="amount">Amount</th>
                <th style="width: 34%;">Deductions</th>
                <th style="width: 16%;" class="amount">Amount</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < $rows; $i++)
                @php
                    $e = $earnings->get($i);
                    $d = $deductions->get($i);
                @endphp
                <tr>
                    <td>{{ $e['name'] ?? '' }}</td>
                    <td class="amount">{{ isset($e['amount']) ? number_format($e['amount'], 2) : '' }}</td>
                    <td>{{ $d['name'] ?? '' }}</td>
                    <td class="amount">{{ isset($d['amount']) ? number_format($d['amount'], 2) : '' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <table class="totals" style="margin-top: 12px;">
        <tr>
            <td class="label" style="width: 84%;">Total Earnings</td>
            <td class="amount" style="width: 16%;">{{ number_format($totalEarnings, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Total Deductions</td>
            <td class="amount">{{ number_format($totalDeductions, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Net Pay</td>
            <td class="amount">{{ number_format((float) $payslip->net_salary, 2) }}</td>
        </tr>
    </table>
</body>
</html>
