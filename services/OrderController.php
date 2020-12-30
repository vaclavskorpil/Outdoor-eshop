<?php


namespace services;


use UserRepository;

class OrderController
{
    static function getPaymentMethods(): array
    {
        return OrderRepository::getPaymentMethods();
    }


    static function getDeliveryMethods(): array
    {
        return OrderRepository::getDeliveryMethods();
    }

    static function getTotalCost()
    {
        $total = 0;
        foreach ($_SESSION["cart"] as $pid => $value) {
            $total += ProductRepository::getTinyById($pid)["price"] * $value["quantity"];
        }
        if (isset($_SESSION["deliveryId"])) {
            $total += ProductRepository::getDeliveryPrice($_SESSION["deliveryId"]);
        }

        if (isset($_SESSION["paymentId"])) {
            $total += ProductRepository::getPaymentPrice($_SESSION["paymentId"]);
        }
        return $total;
    }

    static function canOrder(): bool
    {
        return (isset($_SESSION["deliveryId"]) && isset($_SESSION["paymentId"]));
    }

    static function createOrder()
    {
        $deliveryId = null;
        $paymentMethod = 1;
        $deliveryMethod = 1;

        $deliveryId = $_SESSION["deliveryInfoId"];

        $orderId = OrderRepository::createOrder($deliveryId, $paymentMethod, $deliveryMethod, self::getTotalCost());

        foreach ($_SESSION["cart"] as $pid => $value) {
            ProductRepository::createOrderedProduct($orderId, $pid, $value["quantity"]);
        }


        $_SESSION["cart"] = [];
        unset($_SESSION["deliveryInfo"]);
        unset($_SESSION["deliveryId"]);
        unset($_SESSION["paymentId"]);
    }


}