<?php

namespace Tests\Feature\Domain\Calendars\Actions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SynchronizeCalendarsActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->action = $this->app->make('Domain\Calendars\Actions\SynchronizeCalendarsAction');
    }

    public function test_it_saves_the_file_to_disk(): void
    {
        Http::fake([
            '*' => Http::response(Storage::get('tests/vcalendar.ics'), 200)
        ]);

        $this->action->execute();

        $this->assertFileExists(storage_path('app/kippekont/airbnb.ical'));
    }
}
