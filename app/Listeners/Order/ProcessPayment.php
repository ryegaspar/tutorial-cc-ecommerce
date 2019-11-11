<?php

namespace App\Listeners\Order;

use App\Cart\Cart;
use App\Cart\Payments\Gateway;
use App\Events\Order\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessPayment implements ShouldQueue
{
    protected $gateway;

    /**
     * Create the event listener.
     *
     * @param Gateway $gateway
     */
    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->event;

        $this->gateway
            ->withUser($order->user)
            ->getCustomre()
            ->charge(
                $order->paymentMethod,
                $order->total()->amount()
            );
    }
}
