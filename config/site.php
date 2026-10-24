<?php

/*
| Structure of the public site that is code, not content: the tabs of each
| ministry page and the logo shown for each ministry on the home page.
*/
return [
    'ministries' => [
        'cachorros' => [
            'logo' => 'images/cachorros-logo.png',
            'tabs' => [
                ['slug' => 'general', 'name' => 'General', 'default' => true],
                ['slug' => 'curriculum', 'name' => 'Curriculum'],
                ['slug' => 'honors', 'name' => 'Awards'],
                ['slug' => 'our-countries', 'name' => 'Our Countries'],
            ],
        ],
        'adventurers' => [
            'logo' => 'images/adventurers-logo.png',
            'tabs' => [
                ['slug' => 'general', 'name' => 'General', 'default' => true],
                ['slug' => 'curriculum', 'name' => 'Curriculum'],
                ['slug' => 'honors', 'name' => 'Awards'],
                ['slug' => 'our-countries', 'name' => 'Our Countries'],
            ],
        ],
        'pathfinders' => [
            'logo' => 'images/pathfinders-logo.png',
            'tabs' => [
                ['slug' => 'general', 'name' => 'General', 'default' => true],
                ['slug' => 'curriculum', 'name' => 'Curriculum'],
                ['slug' => 'honors', 'name' => 'Honors'],
                ['slug' => 'our-countries', 'name' => 'Our Countries'],
            ],
        ],
        'ambassadors' => [
            'logo' => 'images/ambassadors-logo.png',
            'tabs' => [
                ['slug' => 'general', 'name' => 'General', 'default' => true],
                ['slug' => 'curriculum', 'name' => 'Curriculum'],
                ['slug' => 'our-countries', 'name' => 'Our Countries'],
            ],
        ],
        'young-adults' => [
            'logo' => 'images/young-adults-logo.png',
            'tabs' => [
                ['slug' => 'general', 'name' => 'General', 'default' => true],
                ['slug' => 'curriculum', 'name' => 'Youth Week of Prayer'],
                ['slug' => 'our-countries', 'name' => 'Our Countries'],
            ],
        ],
        'amicus' => [
            'logo' => 'images/amicus-logo.png',
            'menu_name' => 'AMiCUS',
            'tabs' => [
                ['slug' => 'about', 'name' => 'About', 'default' => true],
                ['slug' => 'starting-uni', 'name' => 'Starting Uni'],
                ['slug' => 'connect', 'name' => 'Connect'],
                ['slug' => 'think', 'name' => 'Think'],
                ['slug' => 'encounter-jesus', 'name' => 'Encounter Jesus'],
                ['slug' => 'be', 'name' => 'Be'],
                ['slug' => 'act', 'name' => 'Act'],
                ['slug' => 'resources', 'name' => 'Resources'],
                ['slug' => 'events', 'name' => 'Events'],
            ],
        ],
    ],
];
