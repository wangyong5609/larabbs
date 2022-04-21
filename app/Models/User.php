<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    protected $fillable = [
        'name', 'email', 'password','introduction','avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function isAuthOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
