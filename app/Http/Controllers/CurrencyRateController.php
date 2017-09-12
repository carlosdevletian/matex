<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrencyRate as Rate;

class CurrencyRateController extends Controller
{
    public function update(Rate $rate)
    {
        $this->validate(request(), [
            'to_dollar' => 'required|numeric'
        ]);

        $rate->update(['to_dollar' => request('to_dollar')]);

        flash()->success('Cambios hechos', '');
        return redirect()->back();
    }
}
