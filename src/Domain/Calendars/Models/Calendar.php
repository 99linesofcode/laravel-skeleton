<?php

namespace Domain\Calendars\Models;

use Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function externalCalendars()
    {
        return $this->hasMany(ExternalCalendar::class);
    }
}
