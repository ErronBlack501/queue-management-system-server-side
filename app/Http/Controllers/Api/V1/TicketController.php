<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ticket;
use App\Models\Counter;
use Illuminate\Http\Request;
use App\Events\TicketCreatedEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Resources\V1\TicketResource;
use App\Http\Resources\V1\TicketCollection;



class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataArray = $request->validate([
            'per_page' => 'integer|min:1'
        ]);
        $nowServingTicket = null;
        $ticket = Ticket::filter();
        $ticket = $ticket->with(['service', 'counter']);
        $ticketKey = Redis::lindex('waitingList', 0);

        if (!is_null($ticketKey)) {
            $nowServingTicket = Redis::hgetall($ticketKey);
        }

        $tickets = $ticket->with(['counter', 'service'])->paginate(empty($dataArray) ? 10 : (int)$dataArray['per_page']);

        return response()->json([
            'nowServing' => $nowServingTicket,
            'tickets' => $tickets, // Laravel ajoute les métadonnées automatiquement
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validate = $request->validate(['service_id' => 'required|numeric|exists:services,id']);

        // Get the available counters for the selected service
        $idleCounters = Counter::where('service_id', $validate['service_id'])
            ->where('counter_status', 'idle')
            ->get();

        // If no idle counters are available, return an error response
        if ($idleCounters->isEmpty()) {
            return response()->json(['message' => 'No idle counters available for the selected service.'], 404);
        }

        // Check the last assigned counter ID in Redis for this service
        $lastAssignedCounterId = (int) Redis::get('last_assigned_counter_id:' . $validate['service_id']);

        // Select the next counter: default to the first one if no last assigned ID exists
        $nextCounter = $idleCounters->first();
        if ($lastAssignedCounterId) {
            $nextCounter = $idleCounters->where('id', '>', $lastAssignedCounterId)->first() ?? $idleCounters->first();
        }

        // Create the new ticket and associate it with the selected counter
        $newTicket = Ticket::create([
            'service_id' => $validate['service_id'],
            'counter_id' => $nextCounter->id,
        ]);

        // Generate the Redis key for this ticket
        $ticketKey = "ticket:{$newTicket->ticket_number}";

        // Store the ticket details in Redis
        Redis::hset($ticketKey, [
            'id' => $newTicket->id,
            'service_name' => $newTicket->service->service_name,
            'ticket_number' => $newTicket->ticket_number,
            'counter_number' => $nextCounter->counter_number,
        ]);

        // Add the ticket to the waiting list in Redis (create the list if it doesn't exist)
        Redis::rpush('waitingList', $ticketKey);

        // Update the last assigned counter ID for this service in Redis
        Redis::set('last_assigned_counter_id:' . $validate['service_id'], $nextCounter->id);

        // Broadcast the TicketCreatedEvent to notify clients
        broadcast(new TicketCreatedEvent($validate['service_id'], $nextCounter->id));

        // Return the newly created ticket as a resource
        return new TicketResource($newTicket);
    }


    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }


    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateTicketRequest $request, Ticket $ticket)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Ticket $ticket)
    // {
    //     //
    // }
}
