<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_no' => $this->transaction_no,
            'amount' => $this->amount,
            'date' => $this->date,
            'loan_percentage' => $this->loan_percentage,
            'status' => ucfirst($this->status),
            'agent_percentage' => $this->agent_percentage,
            'agent' => $this->lead_generator_percentage ?? UserResource::make($this->lead_generator_percentage),
            'lead_generator' => $this->lead_generator_id ?? UserResource::make($this->lead_generator_id),
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}