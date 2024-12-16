<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\TicketHandledEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class QueueController extends Controller
{
    public function index()
    {
        $ticketKeys = Redis::lrange('waitingList', 0, 5);
        $tickets = [];

        foreach ($ticketKeys as $ticketKey) {
            $tickets[] = Redis::hgetall($ticketKey);
        }

        $nowServingTicket = count($tickets) > 0 ? array_shift($tickets) : null;

        return response()->json([
            'nowServingTicket' => $nowServingTicket,
            'tickets' => $tickets,
        ]);
    }

    public function lpop()
    {

        $listKey = 'waitingList';

        $hashKey = Redis::lpop($listKey);

        if (!$hashKey) {
            return response()->json([
                'message' => "The list is empty or doesn't exist."
            ], 404);
        }

        Redis::del($hashKey);

        broadcast(new TicketHandledEvent());

        return response()->json([
            'message' => "The element '$hashKey' has been removed from the list and deleted from Redis."
        ], 200);
    }
}
