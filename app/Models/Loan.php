<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = [
        'amount', 'date', 'loan_percentage', 'agent_percentage', 'agent_id', 'lead_generator_percentage', 'lead_generator_id'
    ];

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
