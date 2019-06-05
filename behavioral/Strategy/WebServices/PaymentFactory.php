<?php

require_once("CreditCardPayment.php");
require_once("PayPalPayment.php");

class PaymentFactory
{
    public static function getPaymentMethod($id){
        switch ($id){
            case "cc":
                return new CreditCardPayment();
            case "paypal":
                return new PayPalPayment();
            default:
                throw new Exception("Unknown Payment Method");
        }
    }
}