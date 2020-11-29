<?php


namespace services;


class OrderRepository
{
    static function getPaymentMethods(): array
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT * FROM PAYMENT_METHOD"
        );
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    static function getDeliveryMethods(): array
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT * FROM DELIVERY_METHOD"
        );
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    static function createOrder(int $deliveryInfoId, ?int $userId, int $paymentMethod, int $deliveryMethod, float $price): int
    {
        $orderStatus = 1;
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "INSERT INTO SHOP_ORDER (delivery_info, id_user, id_order_status, id_payment_method, id_delivery_method, price)
                                values (:deliveryInfo , :userId , :orderStatus , :paymentMethod, :deliveryMethod, :price )"
        );
        $stmt->bindParam(':deliveryInfo', $deliveryInfoId);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':orderStatus', $orderStatus);
        $stmt->bindParam(':paymentMethod', $paymentMethod);
        $stmt->bindParam(':deliveryMethod', $deliveryMethod);
        $stmt->bindParam(':price', $price);
        $stmt->execute();

        $_SESSION["cart"] = [];
        unset($_SESSION["deliveryInfo"]);
        unset($_SESSION["deliveryId"]);
        unset($_SESSION["paymentId"]);
        return $pdo->lastInsertId();
    }
}