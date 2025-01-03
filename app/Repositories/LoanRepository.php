<?php

namespace App\Repositories;

use App\Models\Loan;
use Illuminate\Support\Facades\Hash;

class LoanRepository {
    protected $model;

    public function __construct(Loan $model) {
        $this->model = $model;
    }

    public function findById($id) {
        return $this->model->find($id);
    }

    public function getAll() {
        return $this->model->orderBy('created_at', 'desc')->paginate(10);
    }

    public function searchAndPaginate($searchTerm, $perPage)
    {
        $query = $this->model->query();

        // Filter loans created by the authenticated user
        $query->where('user_id', auth()->id());

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('transaction_no', 'like', "%{$searchTerm}%")
                ->orWhere('status', 'like', "%{$searchTerm}%");
            });
        }

        return $query->with(['user', 'agent', 'leadGenerator'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function finByTransactionNo($transactionNo) {
        $query = $this->model->query();
        
        return $query->where('transaction_no', $transactionNo)->first();
    }

    public function create(array $data) {
        return $this->model->create($data);
    }

    public function update(Loan $model, array $data) {
       $model->update($data);
       return $model;
    }

    public function delete(Loan $model) {
        return $model->delete();
    }

}