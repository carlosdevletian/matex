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
