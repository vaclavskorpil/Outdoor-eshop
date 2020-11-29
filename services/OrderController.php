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
            $total += ProductRepository::getDeliveryPrice($_SESSION["paymentId"]);
        }
        return $total;
    }

    static function createOrder()
    {
        $userId = null;
        $deliveryId = null;
        $paymentMethod = 1;
        $deliveryMethod = 1;

        if (isset($_SESSION[USER_ID])) {
            $userId = $_SESSION[USER_ID];
        }

        if (isset($_SESSION["useMyProfile"])) {
            $info = UserRepository::getUsersDeliveryInfo($_SESSION[USER_ID]);
            $deliveryId = DeliveryRepository::copyRow($info["id"]);
        } else {
            $deliveryId = $_SESSION["deliveryInfo"];
        }

        $orderId = OrderRepository::createOrder($deliveryId, $userId, $paymentMethod, $deliveryMethod, self::getTotalCost());

        foreach ($_SESSION["cart"] as $pid => $value) {
            ProductRepository::createOrderedProduct($orderId, $pid, $value["quantity"]);
        }

    }

}