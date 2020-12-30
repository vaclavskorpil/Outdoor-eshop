<?php

namespace services;

use PDO;

class DeliveryRepository
{
    static function create(string $name, string $surname, string $email, int $phone_number, string $city, string $street, int $home_number, int $zip, ?int $idUser): int
    {

        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("INSERT INTO DELIVERY_INFO
                    SET name=:name , surname = :surname , email = :email 
                        , phone_number = :phone_number , city = :city,
                        street = :street , home_number = :home_number,
                        zip = :zip, id_user = :id_user");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':home_number', $home_number);
        $stmt->bindParam(':zip', $zip);
        $stmt->bindParam(':id_user', $idUser);
        $stmt->execute();

        return $pdo->lastInsertId();

    }

    public static function getById($id)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT * FROM DELIVERY_INFO WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public static function deleteDeliveryInfo($deliveryId)
    {
        $pdo = Connection::getPdoInstance();

        $stmt = $pdo->prepare("DELETE FROM DELIVERY_INFO WHERE id = :id");
        $stmt->bindParam(':id', $deliveryId);
        $stmt->execute();
    }

    public static function canEditDeliveryInfo($deliveryId): bool
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT id_order_status FROM SHOP_ORDER WHERE delivery_info = :id");
        $stmt->bindParam(":id", $deliveryId);
        $stmt->execute();
        $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($statuses as $status) {
            if ($status["id_order_status"] != 4) {
                return false;
            }
        }
        return true;
    }

    public static function canDeleteDeliveryInfo($deliveryId): bool
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT * FROM SHOP_ORDER WHERE delivery_info = :id");
        $stmt->bindParam(":id", $deliveryId);
        $stmt->execute();
        $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return !$statuses;
    }

    static function updateDeliveryInfo(string $name, string $surname, string $email, int $phone_number, string $city, string $street, int $home_number, int $zip, $id)
    {

        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("UPDATE DELIVERY_INFO
                    SET name=:name , surname = :surname , email = :email 
                        , phone_number = :phone_number , city = :city,
                        street = :street , home_number = :home_number,
                        zip = :zip where id=:id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':home_number', $home_number);
        $stmt->bindParam(':zip', $zip);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}