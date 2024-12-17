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

    public function create(array $data) {
        return $this->model->create($data);
    }

    public function update(Loan $model, array $data) {
       $model->update($data);
       return $model;
    }

    public function delete(Loan $model) {
        $model->delete();
    }

}