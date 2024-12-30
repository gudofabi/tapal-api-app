<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Loan extends Model
{
    protected $fillable = [
        'amount', 'date', 'loan_percentage', 'agent_percentage', 'agent_id', 'lead_generator_percentage', 'lead_generator_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($loan) {
            $loan->transaction_no = self::generateTransactionNumber();
        });
    }

    private static function generateTransactionNumber(): string
    {
        do {
            $firstPart = rand(10000, 99999);
            $secondPart = rand(100, 999);
            $transactionNo = "LOAN-{$firstPart}-{$secondPart}";
        } while (self::where('transaction_no', $transactionNo)->exists());

        return $transactionNo;
    }

    /**
     * Get the agent (middleman) associated with the loan.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Get the lead generator associated with the loan.
     */
    public function leadGenerator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lead_generator_id');
    }
}
