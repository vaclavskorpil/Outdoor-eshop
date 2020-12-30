<?php


namespace services;


use PDO;

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

    static function createOrder(int $deliveryInfoId, int $paymentMethod, int $deliveryMethod, float $price): int
    {
        $orderStatus = 1;
        $date = date("Y-m-d H:i:s");
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "INSERT INTO SHOP_ORDER (delivery_info,  id_order_status, id_payment_method, id_delivery_method, price, order_datetime)
                                values (:deliveryInfo  , :orderStatus , :paymentMethod, :deliveryMethod, :price, :order_datetime )"
        );
        $stmt->bindParam(':deliveryInfo', $deliveryInfoId);
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
            "SELECT o.*, s.name as status
            FROM SHOP_ORDER o
            inner join ORDER_STATUS s  on o.id_order_status = s.id
            inner join DELIVERY_INFO DI on o.delivery_info = DI.id
            WHERE DI.id_user = :uid");
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

    static function getAllOrderStates()
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("select * from ORDER_STATUS");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static function changeOrderState($orderId, $stateId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("update SHOP_ORDER SET id_order_status = :status where id = :id");
        $stmt->bindParam(":status", $stateId);
        $stmt->bindParam(":id", $orderId);
        $stmt->execute();
    }

    static function deleteOrder($orderId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("DELETE FROM SHOP_ORDER WHERE id = :id");
        $stmt->bindParam(":id", $orderId);
        $stmt->execute();
    }

    static function getPaymentName($id)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT name from PAYMENT_METHOD where id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)["name"];
    }

    static function getDeliveryMethodName($id)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT name from DELIVERY_METHOD where id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)["name"];
    }

    static function getPaymentMethodForOrder($orderId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT PM.* from SHOP_ORDER o inner join PAYMENT_METHOD PM on o.id_payment_method = PM.id where o.id = :id");
        $stmt->bindParam(":id", $orderId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static function getDeliveryMethodForOrder($orderId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT PM.* from SHOP_ORDER o inner join DELIVERY_METHOD PM on o.id_delivery_method = PM.id where o.id = :id");
        $stmt->bindParam(":id", $orderId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}