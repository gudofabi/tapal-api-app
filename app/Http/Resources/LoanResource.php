<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class LoanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_no' => $this->transaction_no,
            'amount' => $this->amount,
            'date' => $this->date,
            'loan_percentage' => $this->loan_percentage,
            'interest_amount' => $this->calculateInterestAmount(), // Add computed field here
            'status' => ucfirst($this->status),
            'created_by' => new UserResource($this->whenLoaded('user')),
            'agent' => new UserResource($this->whenLoaded('agent')),
            'agent_percentage' => $this->agent_percentage,
            'lead_generator' => new UserResource($this->whenLoaded('leadGenerator')),
            'lead_generator_percentage' => $this->lead_generator_percentage,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }

    /**
     * Calculate the interest amount.
     *
     * @return float
     */
    private function calculateInterestAmount(): float
    {
        return round($this->amount * $this->loan_percentage, 2);
    }

}
