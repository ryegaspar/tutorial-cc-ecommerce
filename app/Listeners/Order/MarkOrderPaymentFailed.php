<?php

namespace App\Listeners\Order;

use App\Events\Order\OrderCreated;
use App\Models\Order;

class MarkOrderPaymentFailed
{
    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle($event)
    {
        $event->order->update([
            'status' => Order::PAYMENT_FAILED
        ]);
    }
}
