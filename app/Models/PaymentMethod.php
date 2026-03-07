<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type', // manual, gateway
        'instructions',
        'account_details',
        'is_active',
    ];

    protected $casts = [
        'account_details' => 'array',
        'is_active' => 'boolean',
    ];

    public function getDetailsAttribute()
    {
        $details = $this->instructions;
        
        if ($this->account_details) {
            $details .= "\n\nAccount Details:\n";
            foreach ($this->account_details as $key => $value) {
                $formattedKey = ucwords(str_replace('_', ' ', $key));
                $details .= "{$formattedKey}: {$value}\n";
            }
        }

        return $details;
    }
}
