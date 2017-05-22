<?php

function flash($title = null, $message = null)
{
	$flash = app('App\Http\Flash');

	if (func_num_args() == 0) {
		return $flash;
	}

	return $flash->info($title, $message);
}

function admin()
{
    return ((auth()->check()) && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')));
}

function owner()
{
    return (auth()->check()) && auth()->user()->hasRole('owner');
}

function month($value)
{
    $months = [
        1 => '            January',
        2 => '           February',
        3 => '             March',
        4 => '               April',
        5 => '               May',
        6 => '               June',
        7 => '               July',
        8 => '             August',
        9 => '          September',
        10 => '            October',
        11 => '          November',
        12 => '           December',
    ];

    return $months[$value];
}

function get_x_coordinates($i)
{
    return $i%3 === 0 ? 510 : 510+(90*($i%3));
}

function get_y_coordinates($i)
{
    if($i < 3) return 330;
    if($i < 6) return 400;
    if($i < 9) return 470;
    if($i < 12) return 540;
    return 210;
}
