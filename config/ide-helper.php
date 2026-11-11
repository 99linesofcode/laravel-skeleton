<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Model locations to include
    |--------------------------------------------------------------------------
    |
    | Where `ide-helper:models` looks for models: Laravel's own in app/Models,
    | and the shape's in each context under src/Core.
    |
    */

    'model_locations' => [
        'app/Models',
        'src/Core',
    ],

];
