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
        $date = date("Y-m-d H:i:s");
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "INSERT INTO SHOP_ORDER (delivery_info, id_user, id_order_status, id_payment_method, id_delivery_method, price, order_datetime)
                                values (:deliveryInfo , :userId , :orderStatus , :paymentMethod, :deliveryMethod, :price, :order_datetime )"
        );
        $stmt->bindParam(':deliveryInfo', $deliveryInfoId);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':orderStatus', $orderStatus);
        $stmt->bindParam(':paymentMethod', $paymentMethod);
        $stmt->bindParam(':deliveryMethod', $deliveryMethod);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':order_datetime', $date);
        $stmt->execute();

        return $pdo->lastInsertId();
    }

    static function getUserOrders(int $userId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT o.*, s.name as status FROM SHOP_ORDER o inner join ORDER_STATUS s  on o.id_order_status = s.id WHERE id_user = :uid");
        $stmt->bindParam(":uid", $userId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    static function getOrderDetail($orderId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT o.*, s.name as status FROM SHOP_ORDER o inner join ORDER_STATUS s  on o.id_order_status = s.id WHERE o.id = :oid");
        $stmt->bindParam(":oid", $orderId);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    static function getAllOrders()
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT o.*, s.name as status
                FROM SHOP_ORDER o
                inner join ORDER_STATUS s  on o.id_order_status = s.id
                inner join DELIVERY_INFO DI on o.delivery_info = DI.id
                order by o.order_datetime desc");
        $stmt->bindParam(":oid", $orderId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}