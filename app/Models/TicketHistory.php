<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'th_status',
        'processed_at',
        'completed_at',
        'canceled_at',
        'processing_duration',
        'handled_by',
        'ticket_id',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
