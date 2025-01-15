<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

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

    public function getUsersByRole($role)
    {
        return $this->userRepository->getUsersByRole($role);
    }

    public function createUser(array $data) {
        // Ensure a hashed password
        $data['password'] = isset($data['password'])
            ? Hash::make($data['password']) // Hash the provided password
            : Hash::make(env('DEFAULT_USER_PASSWORD', 'SecureDefault123')); // Default password

        // Mark email as verified
        $data['email_verified_at'] = Carbon::now();
        $data['role'] = $data['role'] ?? 'agent';
        $data['user_id'] = auth()->id() ?? null;

        return $this->userRepository->create($data);
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