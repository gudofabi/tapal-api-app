<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Loan extends Model
{
    protected $fillable = [
        'transaction_no', 'amount', 'date', 'loan_percentage', 'status', 'agent_percentage', 'agent_id', 'lead_generator_percentage', 'lead_generator_id', 'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set the transaction number and user ID when creating a loan
        static::creating(function ($loan) {
            $loan->transaction_no = self::generateTransactionNumber();

            // Automatically associate the authenticated user
            if (auth()->check()) {
                $loan->user_id = auth()->id(); // Set the user_id to the authenticated user's ID
            }
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


    /**
     * Get the user who created the loan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
