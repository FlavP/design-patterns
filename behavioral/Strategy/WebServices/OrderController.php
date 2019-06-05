<?php
require_once('PaymentMethod.php');
require_once('Order.php');

class OrderController
{
    public function post($url, $data){
        echo "Post request to $url with " . json_encode($data) . "\n";
        $path = parse_url($url, PHP_URL_PATH);
        if(preg_match('#/orders?$#', $path, $matches))
            $this->postNewOrder($data);
        else "Controller: 404 page\n";

    }

    public function get($url){
        echo "Controller: GET request to $url\n";
        $path = parse_url($url, PHP_URL_PATH);
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $data);

        if (preg_match('#/orders?$#', $path, $matches))
            $this->getAllOrders();
        elseif (preg_match('#^/order/([0-9]+?)/payment/([a-z]+?)(/return)?$#', $path, $matches)){
            $order = Order::get($matches[1]);
            $paymentMethod = PaymentMethod::getPaymentMethod($matches[2]);
            if (!isset($matches[3]))
                $this->getPayment($paymentMethod, $order, $data);
            else
                $this->getPaymentReturn($paymentMethod, $order, $data);
        }
        else
            echo "Controller: 404 page\n";
    }

    public function postNewOrder($data){
        $order = new Order($data);
        echo "Controller: Created the order #{$order->id}.\n";
    }

    public function getAllOrders(){
        echo "Controller: Here's all orders:\n";
        foreach (Order::get() as $order)
            echo json_encode($order, JSON_PRETTY_PRINT) . "\n";
    }

    public function getPayment(PaymentMethod $method, Order $order){
        $form = $method->getPaymentForm($order);
        echo "Controller: here's the payment form:\n";
        echo $form . "\n";
    }

    public function getPaymentReturn(PaymentMethod $method, Order $order, $data){
        try{
            if ($method->validateReturn($order, $data)){
                echo "Controller: Thanks for your order!\n";
                $order->complete();
            }
        } catch (Exception $exception){
            echo "Controller: got an exception (" . $exception->getMessage() . ")\n";
        }
    }
}