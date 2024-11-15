<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'ticket_number',
        'ticket_status',
        'service_id',
        'counter_id',
    ];

    protected static function booted(): void
    {
        static::created(function (Ticket $ticket) {
            $ticket->ticket_number = str_pad($ticket->id, 3, '0', STR_PAD_LEFT);
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

    public function ticketHistories()
    {
        return $this->hasMany(TicketHistory::class);
    }
}
