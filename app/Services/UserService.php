<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getAllUser() {
        return $this->userRepository->getAll();
    }

    public function getUserByProfileId($profileId) {
        return $this->userRepository->finByProfileId($profileId);
    }

    public function searchAndPaginate($searchTerm = null, $perPage = 10) {
       return $this->userRepository->searchAndPaginate($searchTerm, $perPage);
    }

    public function updateUser($id, array $data) {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new \Exception('User not found.');
        }
        return $this->userRepository->update($user, $data);
    }

    public function deleteUser($id) {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new \Exception('Loan not found.');
        }
        $this->userRepository->delete($user);
    }

}