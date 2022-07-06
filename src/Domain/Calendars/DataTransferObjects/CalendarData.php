<?php

declare(strict_types=1);

namespace Domain\Calendars\DataTransferObjects;

class CalendarData
{
    public function __construct(
        public readonly string $name,
        public readonly string $description
    ) {
    }
}
