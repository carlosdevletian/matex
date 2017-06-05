<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Status;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatusTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_gets_all_ids_related_to_paid_orders()
    {
        $this->assertEquals([2,3,4,5], Status::paid());
    }

    /** @test */
    public function it_gets_all_ids_related_to_unpaid_orders()
    {
        $this->assertEquals([1], Status::unpaid());
    }

    /** @test */
    public function it_gets_all_ids_related_to_canceled_orders()
    {
        $this->assertEquals([6], Status::canceled());
    }

    /** @test */
    public function it_gets_all_ids_related_to_active_order()
    {
        $this->assertEquals([1, 2, 3, 4], Status::active());
    }
}
