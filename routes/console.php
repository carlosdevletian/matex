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
    $name = $this->choice('Which designs do you wish to delete?', ['0 - User Designs', '1 - Guest Designs', '2 - All Designs', '3 - Cancel']);

    if($name == 0 || $name == 2){
        Storage::deleteDirectory('designs');
        $this->info("User designs deleted");
    }
    if($name == 1 || $name == 2){
        Storage::deleteDirectory('public/designs');
        $this->info("Guest designs deleted");
    }
    if($name > 2 || $name < 0) {
        $this->info("Deletion cancelled");
    }
})->describe('Clear all designs');
