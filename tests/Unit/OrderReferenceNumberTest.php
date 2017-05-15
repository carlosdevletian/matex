<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Order;
use App\OrderReferenceNumber;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderReferenceNumberTest extends TestCase
{
    use DatabaseMigrations;

     /** @test */
    function must_start_with_year_month_and_day()
    {
        $currentDate = Carbon::now()->format('Ymd');
        $number = (new OrderReferenceNumber)->generate();

        $this->assertRegexp("/{$currentDate}/", $number);
    }

     /** @test */
    function must_contain_incrementable_count_of_months_orders()
    {
        factory(Order::class, 99)->create();

        $referenceNumber = (new OrderReferenceNumber)->generate();

        $lastNumber = substr($referenceNumber, strpos($referenceNumber, "-") + 1);  
        $this->assertEquals(100, $lastNumber);
    }
}
