<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\AuthorFilter;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(AuthorFilter $filter): JsonResponse
    {
        $data['authors'] = UserResource::collection(User::filter($filter)->paginate());

        return $this->successResponse(
            message: 'Authors retrieved successfully',
            data: $data,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $author): JsonResponse
    {
        $data['author'] = new UserResource($author);

        return $this->successResponse(
            message: 'Author retrieved successfully',
            data: $data,
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $author)
    {
        //
    }
}
