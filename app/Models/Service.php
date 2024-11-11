<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Service extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'service_name',
        'service_description',
        'estimated_duration',
        'is_active',
    ];

    public function counters()
    {
        return $this->hasMany(Counter::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
