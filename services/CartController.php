<?php


namespace services;

class CartController
{

    static function addToCart($pid)
    {
        if (isset($_SESSION["cart"][$pid])) {

            $_SESSION["cart"][$pid]["quantity"] += 1;
        } else {
            $_SESSION["cart"][$pid]["quantity"] = 1;
        }

    }

    static function removeFromCart($pid)
    {
        if (array_key_exists($pid, $_SESSION["cart"])) {
            if ($_SESSION["cart"][$pid]["quantity"] > 1) {
                $_SESSION["cart"][$pid]["quantity"] -= 1;
            } else {
                unset($_SESSION["cart"][$pid]);
            }
        }
    }

    static function removeAllFromCart($pid)
    {
        if (array_key_exists($pid, $_SESSION["cart"])) {
            unset($_SESSION["cart"][$pid]);
        }
    }

    static function addDelivery($deliveryId)
    {
        $_SESSION["deliveryId"] = $deliveryId;
    }


    static function addPayment($paymentId)
    {
        $_SESSION["paymentId"] = $paymentId;
    }





}