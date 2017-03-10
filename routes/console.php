<?php

use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('clear-designs', function () {
    if ($this->confirm('Are you sure you wish to delete all designs?')) {
        Storage::deleteDirectory('designs');
        Storage::deleteDirectory('public/designs');
        $this->info("Designs deleted successfully");
    }else {
        $this->info("Deletion cancelled");
    }
})->describe('Clear all designs');
