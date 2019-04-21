<?php

class Stripe {
    public function capturePayment($amount){
        /* implementation */
    }

    public function authorizePayment($amount){
        /* implementation */
    }

    public function cancelPayment($amount){
        /* implementation */
    }
}

interface PaymentService{
    public function capture($amount);
    public function authorize($amount);
    public function cancel($amount);
}

class StripePaymentServiceAdapter implements PaymentService{
    private $stripe;

    public function __construct(Stripe $stripe)
    {
        $this->stripe = $stripe;
    }

    public function capture($amount){
        $this->stripe->capturePayment($amount);
    }

    public function authorize($amount){
        $this->stripe->authorizePayment($amount);
    }

    public function cancel($amount){
        $this->stripe->cancelPayment($amount);
    }
}

// Client

$stripe = new StripePaymentServiceAdapter(new Stripe);
$stripe->capture(49.99);
$stripe->authorize(15.99);
$stripe->cancel(23.99);