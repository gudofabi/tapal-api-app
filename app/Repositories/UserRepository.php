<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    protected $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    public function findById($id) {
        return $this->model->find($id);
    }

    public function getAll() {
        return $this->model->orderBy('created_at', 'desc')->paginate(10);
    }

    // public function searchAndPaginate($searchTerm, $perPage)
    // {
    //     $query = $this->model->query();

    //     if ($searchTerm) {
    //         $query->where('profile_id', 'like', "%{$searchTerm}%")
    //             ->orWhere('name', 'like', "%{$searchTerm}%");
    //     }

    //     return $query->orderBy('created_at', 'desc')->paginate($perPage);
    // }
    public function searchAndPaginate($searchTerm, $perPage)
    {
        $query = $this->model->query();

        // Get the authenticated user
        $authUser = auth()->user();

        // Check the role of the authenticated user
        if ($authUser && $authUser->role !== 'admin') {
            // Restrict to users created by the authenticated user
            $query->where('user_id', $authUser->id);
        }

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('profile_id', 'like', "%{$searchTerm}%")
                ->orWhere('name', 'like', "%{$searchTerm}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    

    public function finByProfileId($profileId) {
        $query = $this->model->query();
        
        return $query->where('profile_id', $profileId)->with('loans')->first();
    }

    public function create(array $data) {
       return $this->model->create($data);
    }

    public function update(User $model, array $data) {
       $model->update($data);
       return $model;
    }

    public function delete(User $model) {
        return $model->delete();
    }


}