<!DOCTYPE html>
<html>
<head>
    <title>Invoice - {{ $feeInvoice->invoice_no }}</title>
    <style>
        body { font-family: sans-serif; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
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
        .top {
            margin-bottom: 20px;
        }
        .header-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .item td {
            border-bottom: 1px solid #eee;
        }
        .total td {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .paid {
            color: green;
        }
        .unpaid {
            color: red;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="header-title">
                                School ERP<br>
                                <small>Fee Invoice</small>
                            </td>
                            <td>
                                Invoice #: {{ $feeInvoice->invoice_no }}<br>
                                Created: {{ $feeInvoice->issue_date }}<br>
                                Due: {{ $feeInvoice->due_date }}
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
                                <strong>Bill To:</strong><br>
                                {{ $feeInvoice->student->first_name }} {{ $feeInvoice->student->last_name }}<br>
                                Class: {{ $feeInvoice->student->schoolClass->name }}<br>
                                Admission No: {{ $feeInvoice->student->admission_number }}
                            </td>
                            <td>
                                <strong>Status:</strong><br>
                                <span class="{{ $feeInvoice->status == 'paid' ? 'paid' : 'unpaid' }}">
                                    {{ ucfirst($feeInvoice->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Description</td>
                <td>Amount</td>
            </tr>

            @foreach($feeInvoice->items as $item)
                <tr class="item">
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach

            <tr class="total">
                <td>Subtotal</td>
                <td>{{ number_format($feeInvoice->total_amount, 2) }}</td>
            </tr>

            @if($feeInvoice->fine_amount > 0)
                <tr class="item">
                    <td>Fine</td>
                    <td>{{ number_format($feeInvoice->fine_amount, 2) }}</td>
                </tr>
            @endif

            @if($feeInvoice->discount_amount > 0)
                <tr class="item">
                    <td>Discount</td>
                    <td>-{{ number_format($feeInvoice->discount_amount, 2) }}</td>
                </tr>
            @endif

            <tr class="total">
                <td>Total Payable</td>
                <td>{{ number_format($feeInvoice->total_amount + $feeInvoice->fine_amount - $feeInvoice->discount_amount, 2) }}</td>
            </tr>
            
            <tr class="total">
                <td>Paid Amount</td>
                <td>{{ number_format($feeInvoice->paid_amount, 2) }}</td>
            </tr>
            
            <tr class="total" style="font-size: 18px;">
                <td>Balance Due</td>
                <td>{{ number_format($feeInvoice->balance, 2) }}</td>
            </tr>
        </table>
        
        @if($feeInvoice->payments->count() > 0)
            <div style="margin-top: 30px;">
                <strong>Payment History</strong>
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <tr style="background: #f9f9f9; border-bottom: 1px solid #ddd;">
                        <td style="padding: 5px; font-weight: bold;">Date</td>
                        <td style="padding: 5px; font-weight: bold; text-align: left;">Method</td>
                        <td style="padding: 5px; font-weight: bold; text-align: right;">Amount</td>
                    </tr>
                    @foreach($feeInvoice->payments as $payment)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 5px;">{{ $payment->payment_date }}</td>
                            <td style="padding: 5px; text-align: left;">{{ $payment->payment_method }}</td>
                            <td style="padding: 5px; text-align: right;">{{ number_format($payment->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>
</body>
</html>
