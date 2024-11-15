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

     /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (Counter $counter) {
            $counter->counter_number = $counter->counter_number = str_pad($counter->id, 3, '0', STR_PAD_LEFT);
            $counter->save();
        });
    }

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
