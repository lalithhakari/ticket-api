<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\Tickets\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\Tickets\StoreTicketRequest;
use App\Http\Requests\Api\V1\Tickets\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorTicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $author, TicketFilter $filter): JsonResponse
    {
        $data['tickets'] = TicketResource::collection(
            Ticket::where('user_id', $author->id)->filter($filter)->paginate()
        );

        return $this->successResponse(
            message: 'Tickets retrieved successfully',
            data: $data,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request, User $author): JsonResponse
    {
        $data['ticket'] = new TicketResource(Ticket::create($request->mappedData()));

        return $this->successResponse(
            message: 'Ticket created successfully',
            data: $data,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $author, Ticket $ticket): JsonResponse
    {
        $data['ticket'] = new TicketResource($ticket);

        return $this->successResponse(
            message: 'Ticket retrieved successfully',
            data: $data,
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, User $author, Ticket $ticket): JsonResponse
    {
        $ticket->update($request->mappedData());
        $ticket->fresh();

        $data['ticket'] = new TicketResource($ticket);

        return $this->successResponse(
            message: 'Ticket updated successfully',
            data: $data,
        );
    }

    /**
     * Replace the specified resource in storage.
     */
    public function replace(ReplaceTicketRequest $request, User $author, Ticket $ticket): JsonResponse
    {
        $ticket->update($request->mappedData());
        $ticket->fresh();

        $data['ticket'] = new TicketResource($ticket);

        return $this->successResponse(
            message: 'Ticket replaced successfully',
            data: $data,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $author, Ticket $ticket): JsonResponse
    {
        if (($ticket->user_id !== $author->id) || ($author->id !== $request->user()->id)) {
            return $this->errorResponse(message: 'You are not authorized to delete this ticket');
        }

        $ticket->delete();

        return $this->successResponse(message: 'Ticket deleted successfully');
    }
}
