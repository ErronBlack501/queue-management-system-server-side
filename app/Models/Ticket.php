<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use App\Events\TicketHandledEvent;
use Carbon\Carbon;
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
        'processing_duration',
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
                    $ticketNumber = Redis::incr('ticket_counter');
                } else {
                    Redis::set('ticket_counter', 1);
                }
            } else {
                Redis::set('ticket_counter', 1);
            }

            $ticket->ticket_number = str_pad($ticketNumber, 3, '0', STR_PAD_LEFT);
            $ticket->save();
        });

        static::updated(function (Ticket $ticket) {
            if ($ticket->processing_duration) {
                if ($ticket->processed_at) {
                    $processedAt = Carbon::parse($ticket->processed_at);

                    if ($ticket->completed_at) {
                        $ticket->processing_duration = $processedAt->diff(Carbon::parse($ticket->completed_at))->format('%H:%I:%S');
                    } elseif ($ticket->canceled_at) {
                        $ticket->processing_duration = $processedAt->diff(Carbon::parse($ticket->canceled_at))->format('%H:%I:%S');
                    }

                    $ticket->save();
                }
            }
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
