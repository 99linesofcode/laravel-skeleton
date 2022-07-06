<?php
namespace Domain\Calendars\Actions;

use Domain\Contracts\Action;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SynchronizeCalendarsAction implements Action
{
    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    public function execute(): void
    {
        $vcalendarString = $this->http::get("https://www.airbnb.com/calendar/ical/52947097.ics?s=49555583a0fdae60d232870d103bd97d");
        Storage::disk('local')->put('kippekont/airbnb.ical', $vcalendarString);
    }
}
