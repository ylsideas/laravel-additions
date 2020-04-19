<?php

return [

    'use_custom_make_commands' => true,

    'use_configure_commands' => [
        \YlsIdeas\LaravelAdditions\Commands\ConfigureMacros::class,
        \YlsIdeas\LaravelAdditions\Commands\ConfigureHelpers::class,
    ],
];
