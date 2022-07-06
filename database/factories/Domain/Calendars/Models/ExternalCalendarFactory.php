<?php

namespace Database\Factories\Domain\Calendars\Models;

use Domain\Calendars\Models\ExternalCalendar;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExternalCalendarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExternalCalendar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => 'https://www.airbnb.com/calendar/ical/52947097.ics?s=49555583a0fdae60d232870d103bd97d'
        ];
    }
}
