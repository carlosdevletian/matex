<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\CurrencyRate;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChargingInPesosTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function owner_can_set_a_conversion_rate_for_colombian_pesos()
    {
        $owner = factory(User::class)->states('owner')->create();
        $rate = factory(CurrencyRate::class)->create([
            'currency_code' => 'cop',
            'to_dollar' => 1000
        ]);

        $this->assertEquals('COP', $rate->currency_code);

        $this->signIn($owner)->put(route('currency-rate.update', $rate), [
            'to_dollar' => 3000
        ]);

        $this->assertEquals(3000, $rate->fresh()->to_dollar);
    }
}
