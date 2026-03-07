<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tax Percentage
    |--------------------------------------------------------------------------
    |
    | The default tax percentage applied to subscription invoices.
    |
    */
    'tax_percentage' => env('BILLING_TAX_PERCENTAGE', 16), // Default to 16% (e.g. GST/VAT)

    /*
    |--------------------------------------------------------------------------
    | Invoice Prefix
    |--------------------------------------------------------------------------
    |
    | The prefix used for generated invoice numbers.
    |
    */
    'invoice_prefix' => env('BILLING_INVOICE_PREFIX', 'INV'),
];
