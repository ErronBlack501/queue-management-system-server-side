<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TicketResource;
use App\Http\Resources\V1\TicketCollection;



class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new TicketCollection(Ticket::paginate(10));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(StoreTicketRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Ticket $ticket)
    // {
    //     //
    // }

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
