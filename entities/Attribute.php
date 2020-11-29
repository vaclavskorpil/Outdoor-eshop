<?php

namespace entities;

use services\Connection;

class Attribute
{
    private int $id;
    private int $idProduct;
    private float $width;
    private float $height;
    private float $depth;
    private float $volume;
    private float $weight;
    private int $amountOfPeople;
    private float $temperatureMax;
    private float $temperatureMin;


    /**
     * Attribute constructor.
     */
    public function __construct()
    {
    }


    /**
     * @return float
     */
    public function getTemperatureMax(): float
    {
        return $this->temperatureMax;
    }

    /**
     * @param float $temperatureMax
     */
    public function setTemperatureMax(float $temperatureMax): Attribute
    {
        $this->temperatureMax = $temperatureMax;
        return $this;
    }

    /**
     * @return float
     */
    public function getTemperatureMin(): float
    {
        return $this->temperatureMin;
    }

    /**
     * @param float $temperatureMin
     */
    public function setTemperatureMin(float $temperatureMin): Attribute
    {
        $this->temperatureMin = $temperatureMin;
        return $this;
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
    public function setId(int $id): Attribute
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return float
     */
    public function getWidth(): float
    {
        return $this->width;
    }

    /**
     * @param float $width
     */
    public function setWidth(float $width): Attribute
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * @param float $height
     */
    public function setHeight(float $height): Attribute
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return float
     */
    public function getDepth(): float
    {
        return $this->depth;
    }

    /**
     * @param float $depth
     */
    public function setDepth(float $depth): Attribute
    {
        $this->depth = $depth;
        return $this;
    }

    /**
     * @return float
     */
    public function getVolume(): float
    {
        return $this->volume;
    }

    /**
     * @param float $volume
     */
    public function setVolume(float $volume): Attribute
    {
        $this->volume = $volume;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): Attribute
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmountOfPeople(): int
    {
        return $this->amountOfPeople;
    }

    /**
     * @param int $amountOfPeople
     */
    public function setAmountOfPeople(int $amountOfPeople): Attribute
    {
        $this->amountOfPeople = $amountOfPeople;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdProduct(): int
    {
        return $this->idProduct;
    }

    /**
     * @param int $idProduct
     */
    public function setIdProduct(int $idProduct): Attribute
    {
        $this->idProduct = $idProduct;
        return $this;
    }


    static public function createFromRow(array $row): Attribute
    {
        $instance = new Attribute();
        if (isset($row["id"])) {
            $instance->setId($row["id"]);
        }
        if (isset($row["width"])) {
            $instance->setWidth($row["width"]);
        }
        if (isset($row["height"])) {
            $instance->setHeight($row["height"]);
        }
        if (isset($row["depth"])) {
            $instance->setHeight($row["depth"]);
        }
        if (isset($row["temperature_max"])) {
            $instance->setTemperatureMax($row["temperature_max"]);
        }
        if (isset($row["temperature_min"])) {
            $instance->setTemperatureMin($row["temperature_min"]);
        }
        if (isset($row["volume"])) {
            $instance->setVolume($row["volume"]);
        }
        if (isset($row["amount_of_people"])) {
            $instance->setAmountOfPeople($row["amount_of_people"]);
        }
        if (isset($row["id_product"])) {
            $instance->setIdProduct($row["id_product"]);
        }
        if (isset($row["weight"])) {
            $instance->setWeight($row["weight"]);
        }

        return $instance;
    }

    static function createTent($idProduct, $width, $height, $depth, $personAmount, $weight)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("INSERT INTO ATTRIBUTE set width =:width, height =:height, depth =:depth, amount_of_people =:amount_of_people, weight =:weight, id_product =:id_product");
        $stmt->bindParam(":width", $width);
        $stmt->bindParam(":height", $height);
        $stmt->bindParam(":depth", $depth);
        $stmt->bindParam(":amount_of_people", $personAmount);
        $stmt->bindParam(":weight", $weight);
        $stmt->bindParam(":id_product", $idProduct);

        $stmt->execute();

        $id = $pdo->lastInsertId();
        $attribute = new Attribute();

        $attribute->setIdProduct($idProduct)->setWidth($width)->setHeight($height)->setDepth($depth)->setAmountOfPeople($personAmount)->setWeight($weight)->setId($id);
        return $attribute;
    }


    static function createSleepingBag($idProduct, $width, $depth, $temperatureMax, $temperatureMin, $weight)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("INSERT INTO ATTRIBUTE set width =:width, height =: height, temperature_min =:temperature_min, temperature_max =:temperature_max, weight =:weight, id_product =: id_product");
        $stmt->bindParam(":width", $width);
        $stmt->bindParam(":temperature_max", $temperatureMax);
        $stmt->bindParam(":temperature_min", $temperatureMin);
        $stmt->bindParam(":weight", $weight);
        $stmt->bindParam(":id_product", $idProduct);
        $stmt->execute();

        $id = $pdo->lastInsertId();
        $attribute = new Attribute();

        $attribute->setIdProduct($idProduct)->setWidth($width)->setDepth($depth)->setWeight($weight)->setId($id)->setTemperatureMax($temperatureMax)->setTemperatureMin($temperatureMin);
        return $attribute;
    }

}