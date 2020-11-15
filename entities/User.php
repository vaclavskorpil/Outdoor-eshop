<?php

namespace entities;

use http\Params;
use services\Connection;
use services\Log;

class User
{
    private int $id;
    private string $password;
    private DeliveryInfo $delivery_info;
    private int $role;

    /**
     * User constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole(int $role): User
    {
        $this->role = $role;
        return $this;
    }


    public static function create($id, $password, $deliveryInfo, $role)
    {
        $instance = new self();
        return $instance->setId($id)->setPassword($password)->setDeliveryInfo($deliveryInfo)->setRole($role);
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return DeliveryInfo
     */
    public function getDeliveryInfo(): DeliveryInfo
    {
        return $this->delivery_info;
    }

    /**
     * @param DeliveryInfo $delivery_info
     */
    public function setDeliveryInfo(DeliveryInfo $delivery_info): User
    {
        $this->delivery_info = $delivery_info;
        return $this;
    }

    public function getName(): string
    {
        return $this->delivery_info->getName();
    }

    public function getSurname(): string
    {
        return $this->delivery_info->getSurname();
    }

    public function getCity(): string
    {
        return $this->delivery_info->getCity();
    }

    public function getEmail(): string
    {
        return $this->delivery_info->getEmail();
    }

    public function getStreet(): string
    {
        return $this->delivery_info->getStreet();
    }

    public function getHomeNumber(): int
    {
        return $this->delivery_info->getHomeNumber();
    }

    public function getZip(): int
    {
        return $this->delivery_info->getZip();
    }

    public function getPhoneNumber(): int
    {
        return $this->delivery_info->getPhoneNumber();
    }

    public static function load(array $userRow): User
    {
        $delivery = DeliveryInfo::getById($userRow["delivery_info"]);
        return self::create($userRow["id"], $userRow["password"], $delivery, $userRow["role"]);
    }


}