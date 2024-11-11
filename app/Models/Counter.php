<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'counter_number',
        'counter_status',
        'service_id'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
