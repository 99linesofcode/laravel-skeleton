<?php

namespace Domain\Calendars\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalCalendar extends Model
{
    use HasFactory;

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
