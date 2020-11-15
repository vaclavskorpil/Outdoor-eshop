<?php

namespace entities;

use mysql_xdevapi\Exception;
use services\Connection;
use services\Log;

class DeliveryInfo
{

    private int $id;
    private string $name;
    private string  $surname;
    private string  $email;
    private int  $phone_number;
    private string $city;
    private string $street;
    private int $home_number;
    private int $zip;


    public function __construct()
    {
    }

    public static function create(int $id, string $name, string $surname, string $email, int $phone_number, string $city, string $street, int $home_number, int $zip)
    {
        $instance = new self();
        $instance->setId($id)
            ->setCity($city)
            ->setEmail($email)
            ->setHomeNumber($home_number)
            ->setName($name)
            ->setStreet($street)
            ->setSurname($surname)
            ->setZip($zip)
            ->setPhoneNumber($phone_number);
        return $instance;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function setId(int $id): DeliveryInfo
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): DeliveryInfo
    {
        $this->name = $name;
        return $this;
    }


    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): DeliveryInfo
    {
        $this->surname = $surname;
        return $this;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): DeliveryInfo
    {
        $this->email = $email;
        return $this;
    }


    public function getPhoneNumber(): int
    {
        return $this->phone_number;
    }


    public function setPhoneNumber(int $phone_number): DeliveryInfo
    {
        $this->phone_number = $phone_number;
        return $this;
    }


    public function getCity(): string
    {
        return $this->city;
    }


    public function setCity(string $city): DeliveryInfo
    {
        $this->city = $city;
        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): DeliveryInfo
    {
        $this->street = $street;
        return $this;
    }


    public function getHomeNumber(): int
    {
        return $this->home_number;
    }

    public function setHomeNumber(int $home_number): DeliveryInfo
    {
        $this->home_number = $home_number;
        return $this;
    }


    public function getZip(): int
    {
        return $this->zip;
    }

    public function setZip(int $zip): DeliveryInfo
    {
        $this->zip = $zip;
        return $this;
    }

    function createFromRow(array $deliveryRow)
    {
        foreach ($deliveryRow as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**creates new row in databese and returns it*/
    static function createRow(string $name, string $surname, string $email, int $phone_number, string $city, string $street, int $home_number, int $zip): ?DeliveryInfo
    {
        try {
            $pdo = Connection::getPdoInstance();
            $stmt = $pdo->prepare("INSERT INTO DELIVERY_INFO
                    SET name=:name , surname = :surname , email = :email 
                        , phone_number = :phone_number , city = :city,
                        street = :street , home_number = :home_number,
                        zip = :zip");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':street', $street);
            $stmt->bindParam(':home_number', $home_number);
            $stmt->bindParam(':zip', $zip);
            $stmt->execute();

            $id_new = $pdo->lastInsertId();
            Log::write_line("new id " . $id_new);;
            return DeliveryInfo::create($id_new, $name, $surname, $email, $phone_number, $city, $street, $home_number, $zip);
        } catch (Exception $e) {
            var_dump($e);
            Log::write_line($e);
        }
    }

    public static function getById(int $id): ?DeliveryInfo
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT * FROM DELIVERY_INFO WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        $deli = new DeliveryInfo();
        $deli->createFromRow($row);
        return $deli;
    }


    public static function getByEmail(string $email): ?DeliveryInfo
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT * FROM DELIVERY_INFO WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();
        $deli = new DeliveryInfo();
        $deli->createFromRow($row);
        return $deli;
    }

    public static function update($email, $name, $surname, $phone_number, $city, $street, $home_number, $zip)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("UPDATE DELIVERY_INFO SET name =:name , surname =:surname , city :=city, street =:street , home_number:= home_number ,zip =:zip where email :=email");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':home_number', $home_number);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':zip', $zip);
        $stmt->execute();
    }

    public static function updateByUserId($userId, $name, $surname, $phone_number, $city, $street, $home_number, $zip)
    {
        Log::write_line("updating by id ");
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("select d.id from USER u inner join  DELIVERY_INFO d on u.delivery_info = d.id where u.id =:id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $deliId = $stmt->fetch();
        $id = $deliId["id"];
        $stmt = $pdo->prepare("UPDATE DELIVERY_INFO SET name =:name , surname =:surname , city =:city, street =:street , home_number=:home_number,phone_number =:phone_number ,zip =:zip where id =:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':street', $street);

        $stmt->bindParam(':home_number', $home_number);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':zip', $zip);
        $stmt->execute();
    }

}