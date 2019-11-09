<?php

namespace App\Cart\Payments\Gateways;

use App\Cart\Payments\GatewayCustomer;
use App\Models\PaymentMethod;

class StripeGatewayCustomer implements GatewayCustomer
{
    public function charge(PaymentMethod $card, $amount)
    {
        // TODO: Implement charge() method.
    }

    public function addCard($token)
    {
        // TODO: Implement addCard() method.
    }
}
