<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
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
            'data' => $response,
            'message' => 'User successfully get!'
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
}
