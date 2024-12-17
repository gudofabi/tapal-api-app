<?php

namespace App\Services;

use App\Repositories\LoanRepository;

class LoanService
{
    protected $loanRepository;

    public function __construct(LoanRepository $loanRepository) {
        $this->loanRepository = $loanRepository;
    }

    public function getAllLoan() {
        return $this->loanRepository->getAll();
    }

    public function createLoan(array $data) {
        $loan =  $this->loanRepository->create($data);
        return $loan;
    }

    public function updateLoan($id, array $data) {
        $loan = $this->loanRepository->findById($id);
        if (!$loan) {
            throw new \Exception('Loan not found.');
        }
        return $this->loanRepository->update($task, $data);
    }

    public function deleteLoan($id) {
        $loan = $this->loanRepository->findById($id);
        if (!$loan) {
            throw new \Exception('Loan not found.');
        }
        $this->loanRepository->delete($loan);
    }
}