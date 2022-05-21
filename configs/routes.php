<?php

$routes = array(
    'MovieController' => array(
        'beatfilm-movies' => 'main',
        'movies/([0-9]+)' => 'saved/$1',
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
);
