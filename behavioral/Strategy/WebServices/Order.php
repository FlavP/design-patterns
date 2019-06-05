<?php


class Order
{
    private static $orders = [];

    public static function get($orderId = null){
        if ($orderId === null)
            return self::$orders;
        else
            return self::$orders[$orderId];
    }

    public function __construct($attributes)
    {
        $this->id = count(self::$orders);
        $this->status = "new";
        foreach ($attributes as $key => $value)
            $this->{$key} = $value;
        self::$orders[$this->id] = $this;
    }

    public function complete(){
        $this->status = "completed";
        echo "Order: #{$this->id} is now {$this->status}.";
    }
}