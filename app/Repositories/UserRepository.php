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

    public function searchAndPaginate($searchTerm, $perPage)
    {
        $query = $this->model->query();

        if ($searchTerm) {
            $query->where('profile_id', 'like', "%{$searchTerm}%")
                ->orWhere('name', 'like', "%{$searchTerm}%");
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function finByProfileId($profileId) {
        $query = $this->model->query();
        
        return $query->where('profile_id', $profileId)->first();
    }

    public function update(User $model, array $data) {
       $model->update($data);
       return $model;
    }

    public function delete(User $model) {
        return $model->delete();
    }


}