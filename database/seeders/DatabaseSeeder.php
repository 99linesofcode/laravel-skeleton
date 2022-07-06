<?php

namespace Database\Seeders;

use Domain\Models\User;
use Domain\Calendars\Models\Calendar;
use Domain\Calendars\Models\ExternalCalendar;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)
            ->has(Calendar::factory()->has(ExternalCalendar::factory()->count(2), 'externalCalendars'))
            ->create();
    }
}
