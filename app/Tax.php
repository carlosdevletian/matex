<?php

namespace App;

class Tax
{
    public function calculate($state)
    {
        if($state === 'FL') return 0.07;

        return 0;
    }
}
