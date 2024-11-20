<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('notifications', function () {
    return true;
});

Broadcast::channel('service.{id}', function (User $user, $id) {
    if ((int) $user->counter->service_id === (int) $id) {
        return $user->only('id', 'name', 'email', 'role');
    }
});
