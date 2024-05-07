<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AuthorTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($authorId, TicketFilter $filter)
    {
        return TicketResource::collection(
            Ticket::where('user_id', $authorId)->filter($filter)->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request, $authorId)
    {
        $data = [
            'user_id'       => $authorId,
            'title'         => $request->input('data.attributes.title'),
            'description'   => $request->input('data.attributes.description'),
            'status'        => $request->input('data.attributes.status'),
        ];

        return new TicketResource(Ticket::create($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
