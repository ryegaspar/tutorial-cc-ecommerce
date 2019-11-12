<?php

namespace App\Listeners\Order;

use App\Cart\Cart;
use App\Events\Order\OrderCreated;

class EmptyCart
{
    protected $cart;

    /**
     * Create the event listener.
     *
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $this->cart->empty();
    }
}
