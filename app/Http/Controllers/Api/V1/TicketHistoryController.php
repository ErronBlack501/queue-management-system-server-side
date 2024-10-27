<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\TicketHistory;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TicketHistoryResource;
use App\Http\Resources\V1\TicketHistoryCollection;

class TicketHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new TicketHistoryCollection(TicketHistory::paginate(10));
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
    // public function store(StoreTicketHistoryRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(TicketHistory $ticketHistory)
    {
        return new TicketHistoryResource($ticketHistory);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(TicketHistory $ticketHistory)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateTicketHistoryRequest $request, TicketHistory $ticketHistory)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(TicketHistory $ticketHistory)
    // {
    //     //
    // }
}
