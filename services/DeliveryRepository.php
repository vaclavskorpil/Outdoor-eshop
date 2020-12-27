<?php

namespace services;

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

    public static function getByUserId(int $uid)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT * from DELIVERY_INFO WHERE id = :id");
        $stmt->bindParam(':id', $uid);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function copyRow(int $deliveryId): int
    {

        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("INSERT INTO DELIVERY_INFO (name, surname, email, phone_number, city, street, home_number, zip) SELECT name, surname, email, phone_number, city, street, home_number, zip FROM DELIVERY_INFO WHERE ID = :id
        ");
        $stmt->bindParam(':id', $deliveryId);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    public static function deleteDeliveryInfo($deliveryId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("DELETE FROM DELIVERY_INFO WHERE id = :id");
        $stmt->bindParam(':id', $deliveryId);
        $stmt->execute();
    }

}