<?php

namespace App\Cart\Payments\Gateways;

use App\Cart\Payments\Gateway;
use App\Cart\Payments\GatewayCustomer;
use App\Models\PaymentMethod;
use Stripe\Customer as StripeCustomer;

class StripeGatewayCustomer implements GatewayCustomer
{
    protected $gateway;
    protected $customer;

    public function __construct(Gateway $gateway, StripeCustomer $customer)
    {
        $this->gateway = $gateway;
        $this->customer = $customer;
    }

    public function charge(PaymentMethod $card, $amount)
    {
        // TODO: Implement charge() method.
    }

    public function addCard($token)
    {
        $card = $this->customer->sources->create([
            'source' => $token
        ]);

        $this->customer->default_source = $card->id;
        $this->customer->save();

        return $this->gateway->user()->paymentMethods()->create([
            'provider_id' => $card->id,
            'card_type'   => $card->brand,
            'last_four'   => $card->last4,
            'default'     => true,
        ]);
    }

    public function id()
    {
        return $this->customer->id;
    }
}