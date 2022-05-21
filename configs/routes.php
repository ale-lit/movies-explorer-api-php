<?php

$routes = array(
    'MovieController' => array(
        'beatfilm-movies' => 'main',
        'movies' => 'saved'

    ),
    'SignupController' => array(
        'signup' => 'main'
    ),
    'SigninController' => array(
        'signin' => 'main'
    ),
    'UserController' => array(
        'users/me' => 'main'
    ),
    // 'SeanceController' => array(        
    //     'seances/date/([0-9]+\-[0-9]+\-[0-9]+)' => 'date/$1',
    //     'seances/([0-9]+)' => 'main/$1',
    //     'seances' => 'main'
    // ),
    // 'PlaceController' => array(
    //     'places/check/' => 'check',
    //     'places/([0-9]+)' => 'main/$1'
    // ),
    // 'TicketController' => array(
    //     'tickets/([0-9]+)' => 'main/$1',
    //     'tickets' => 'main'
    // )
);
