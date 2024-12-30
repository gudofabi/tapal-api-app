<?php

namespace App\Http\Controllers;

use App\Services\LoanService;
use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService) {
        $this->loanService = $loanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default to 10 items per page

        $loans = $this->loanService->searchAndPaginate($searchTerm, $perPage);
        return LoanResource::collection($loans);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanRequest $request)
    {
        $data = $request->all();
        $response = $this->loanService->createLoan($data);
        return response()->json([
            'data' => new LoanResource($response),
            'message' => 'Loan successfully created!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoanRequest $request, $id)
    {
        try {
            $response = $this->loanService->updateLoan($id, $request->all());
            return response()->json([
                'data' => new LoanResource($response),
                'message' => 'Loan successfully updated!'
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
        $this->loanService->deleteLoan($id);
        return response()->json(['message' => 'Loan successfully deleted!']);
    }
}
