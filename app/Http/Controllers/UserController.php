<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserWithLoanResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\DropdownResource;
use Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default to 10 items per page

        $response = $this->userService->searchAndPaginate($searchTerm, $perPage);
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show($profileId)
    {
        $response = $this->userService->getUserByProfileId($profileId);
        return response()->json([
            'data'    => new UserWithLoanResource($response),
            'message' => 'User successfully get!'
        ]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $response = $this->userService->createUser($data);
        return response()->json([
            'data' => new UserResource($response),
            'message' => 'User successfully created!'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $response = $this->userService->updateUser($id, $request->all());
            return response()->json([
                'data' => $response,
                'message' => 'User successfully updated!'
            ]);;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return response()->json(['message' => 'User successfully deleted!']);
    }


    /**
     * Fetch users based on their roles.
     */
    public function getUsersByRole($role)
    {
        try {
            $users = $this->userService->getUsersByRole($role);
            return response()->json([
                'data' =>  DropdownResource::collection($users),
                'message' => 'Users successfully fetched based on role!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
