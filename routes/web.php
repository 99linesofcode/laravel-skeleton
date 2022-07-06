<?php

use Illuminate\Support\Facades\Route;
use Kigkonsult\Icalcreator\Vcalendar;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Domain\Calendars\DataTransferObjects\CalendarData;

Route::get('/', function () {
    $data = new CalendarData(
        'Stijlvolle loft te midden van Strijp-S',
        'Modern ingerichte loft in voormalig Philips fabriek. Van alle gemakken voorzien.'
    );

    dd($data->name, $data->description);
});

// Route::get('/import', function () {
//     //Load primary calendar from local file
//     $vcalendarPrimary   = new Vcalendar([ Vcalendar::UNIQUE_ID => "primary" ]);
//     $iCalContent = Storage::get('test.ical');
//     $vcalendarPrimary->parse($iCalContent);

//     //Load airbnb calendar
//     $vcalendarAirbnb   = new Vcalendar([ Vcalendar::UNIQUE_ID => "airbnb" ]);
//     $iCalContent = file_get_contents("https://www.airbnb.nl/calendar/ical/52947097.ics?s=49555583a0fdae60d232870d103bd97d");
//     $vcalendarAirbnb->parse($iCalContent);

//     //Search for new bookings and add to primary calendar
//     while ($booking = $vcalendarAirbnb->getComponent()) {
//         $searchArray = [ Vcalendar::UID => $booking->getUid()];
//         $duplicates = $vcalendarPrimary->selectComponents($searchArray);
//         if (empty($duplicates)) {
//             $vcalendarPrimary->setComponent($booking);
//         }
//     }
//     SaveCalendar($vcalendarPrimary);
//     dd($vcalendarPrimary);
// });

// Route::get('/export', function () {
//     $vcalendarPrimary   = new Vcalendar([ Vcalendar::UNIQUE_ID => "primary" ]);
//     $iCalContent = Storage::get('test.ical');
//     $vcalendarPrimary->parse($iCalContent);

//     //Returns .ics file
//     $vcalendarPrimary->returnCalendar();
// });

// Route::get('/add', function () {
//     //Get primary calendar
//     $vcalendarPrimary = new Vcalendar([ Vcalendar::UNIQUE_ID => "primary" ]);
//     $iCalContent = Storage::get('test.ical');
//     $vcalendarPrimary->parse($iCalContent);

//     //Create new event
//     $vcalendarPrimary->newVevent()
//         ->setSummary('Maya (Not available)')
//         ->setDtstart(
//             new DateTime(
//                 $_REQUEST['s']
//             )
//         )
//         ->setDtend(
//             new DateTime(
//                 $_REQUEST['e']
//             )
//         )
//         ->createUid();
//     SaveCalendar($vcalendarPrimary);
// });
