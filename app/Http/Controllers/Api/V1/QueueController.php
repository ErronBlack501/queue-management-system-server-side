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
                'message' => 'La liste est vide ou n\'existe pas.'
            ], 404);
        }

        Redis::del($hashKey);

        broadcast(new TicketHandledEvent());

        return response()->json([
            'message' => "L'élément '$hashKey' a été retiré de la liste et supprimé de Redis."
        ], 200);
    }
}
