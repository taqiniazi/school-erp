<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $payment->invoice_number ?? $payment->transaction_reference }}</title>
    <style>
        body { font-family: sans-serif; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .top { padding-bottom: 20px; }
        .top-title { font-size: 45px; line-height: 45px; color: #333; }
        .information { padding-bottom: 40px; }
        .heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .item td { border-bottom: 1px solid #eee; }
        .total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
        .status-paid { color: green; font-weight: bold; border: 2px solid green; padding: 5px 10px; display: inline-block; transform: rotate(-15deg); }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="top-title">
                                Invoice
                            </td>
                            <td>
                                Invoice #: {{ $payment->invoice_number ?? $payment->transaction_reference }}<br>
                                Date: {{ $payment->invoice_date ? $payment->invoice_date->format('M d, Y') : $payment->created_at->format('M d, Y') }}<br>
                                Transaction Ref: {{ $payment->transaction_reference }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Billed To:</strong><br>
                                {{ $payment->billing_details['name'] ?? $payment->school->name }}<br>
                                {{ $payment->billing_details['address'] ?? $payment->school->address }}<br>
                                {{ $payment->billing_details['email'] ?? $payment->school->email }}<br>
                                @if(isset($payment->billing_details['tax_id']))
                                Tax ID: {{ $payment->billing_details['tax_id'] }}
                                @endif
                            </td>
                            <td>
                                <strong>Pay To:</strong><br>
                                School ERP Corp<br>
                                123 Tech Park, Suite 400<br>
                                Lahore, Pakistan<br>
                                billing@schoolerp.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
            </tr>
            <tr class="item">
                <td>
                    {{ $payment->plan->name }} Plan ({{ ucfirst($payment->plan->billing_cycle) }})<br>
                    <small>Subscription Period: {{ $payment->subscription->current_period_start->format('M d, Y') }} - {{ $payment->subscription->current_period_end->format('M d, Y') }}</small>
                </td>
                <td>Rs. {{ number_format($payment->subtotal ?? $payment->amount, 2) }}</td>
            </tr>
            
            @if(($payment->tax_amount ?? 0) > 0)
            <tr class="item">
                <td>Tax ({{ $payment->tax_percentage }}%)</td>
                <td>Rs. {{ number_format($payment->tax_amount, 2) }}</td>
            </tr>
            @endif

            <tr class="total">
                <td></td>
                <td>Total: Rs. {{ number_format($payment->amount, 2) }}</td>
            </tr>
        </table>
        
        <br><br>
        <div style="text-align: center;">
            <div class="status-paid">PAID</div>
            <p>Payment Method: {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
        </div>
    </div>
</body>
</html>
