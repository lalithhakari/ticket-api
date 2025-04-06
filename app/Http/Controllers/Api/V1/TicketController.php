<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\Tickets\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\Tickets\StoreTicketRequest;
use App\Http\Requests\Api\V1\Tickets\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Policies\V1\Tickets\TicketPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketController extends ApiController
{
    /**
     * The V1 policy class for the resource.
     *
     * @var string
     */
    protected $policyClass = TicketPolicy::class;

    public function __construct()
    {
        Gate::policy(Ticket::class, $this->policyClass);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filter)
    {
        return TicketResource::collection(Ticket::filter($filter)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        return new TicketResource(Ticket::create($request->mappedData()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $this->isAble('update', $ticket);

        $ticket->update($request->mappedData());
        $ticket->fresh();

        return new TicketResource($ticket);
    }

    /**
     * Replace the specified resource in storage.
     */
    public function replace(ReplaceTicketRequest $request, Ticket $ticket)
    {
        $this->isAble('replace', $ticket);

        $ticket->update($request->mappedData());
        $ticket->fresh();

        return new TicketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Ticket $ticket)
    {
        $this->isAble('destroy', $ticket);

        $ticket->delete();

        return $this->successResponse(message: 'Ticket deleted successfully');
    }
}
