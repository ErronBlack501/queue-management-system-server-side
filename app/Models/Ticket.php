<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Ticket extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'ticket_number',
        'ticket_status',
        'processed_at',
        'completed_at',
        'canceled_at',
        'service_id',
        'counter_id',
    ];

    protected static function booted(): void
    {
        static::created(function (Ticket $ticket) {
            $latestTicket = Ticket::latest()->first();
            $ticketNumber = 1;

            if ($latestTicket) {
                $latestTicketDate = $latestTicket->created_at->toDateString();
                $currentTicketDate = $ticket->created_at->toDateString();

                if ($latestTicketDate === $currentTicketDate) {
                    $ticketNumber = Redis::incr('ticket_number');
                } else {
                    Redis::set('ticket_number', 1);
                }
            } else {
                Redis::set('ticket_number', 1);
            }

            $ticket->ticket_number = str_pad($ticketNumber, 3, '0', STR_PAD_LEFT);
            $ticket->save();
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }
}
