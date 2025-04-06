<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\Tickets\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\Tickets\StoreTicketRequest;
use App\Http\Requests\Api\V1\Tickets\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorTicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $author, TicketFilter $filter)
    {
        return TicketResource::collection(
            Ticket::where('user_id', $author->id)->filter($filter)->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request, User $author)
    {
        return new TicketResource(Ticket::create($request->mappedData()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $author, Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, User $author, Ticket $ticket)
    {
        $ticket->update($request->mappedData());
        $ticket->fresh();
        return new TicketResource($ticket);
    }

    /**
     * Replace the specified resource in storage.
     */
    public function replace(ReplaceTicketRequest $request, User $author, Ticket $ticket)
    {
        $ticket->update($request->mappedData());
        $ticket->fresh();
        return new TicketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $author, Ticket $ticket)
    {
        if (($ticket->user_id !== $author->id)  || ($author->id !== $request->user()->id)) {
            return $this->errorResponse(message: 'You are not authorized to delete this ticket');
        }

        $ticket->delete();

        return $this->successResponse(message: 'Ticket deleted successfully');
    }
}
