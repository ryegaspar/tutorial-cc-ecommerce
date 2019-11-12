<?php

namespace Tests\Unit\Listeners;

use App\Events\Order\OrderPaid;
use App\Listeners\Order\MarkOrderPaymentFailed;
use App\Listeners\Order\MarkOrderProcessing;
use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class MarkOrderProcessingListenerTest extends TestCase
{
    /** @test */
    public function it_marks_order_as_processing()
    {
        $event = new OrderPaid(
            $order = factory(Order::class)->create([
                'user_id' => factory(User::class)->create()
            ])
        );

        $listener = new MarkOrderProcessing();
        $listener->handle($event);

        $this->assertEquals($order->fresh()->status, Order::PROCESSING);
    }
}
