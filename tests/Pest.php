<?php

declare(strict_types=1);

use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Feature tests run on the booted application through Tests\TestCase. Unit
| and arch tests run on Pest's own test case.
|
*/

pest()->extend(TestCase::class)->in('Feature');
