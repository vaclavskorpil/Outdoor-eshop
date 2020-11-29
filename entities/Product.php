<?php

namespace entities;

use entities\Category;
use services\Connection;
use services\Log;

class Product
{
    private int $id;
    private int $category_id;
    private float $price;
    private string $name;
    private string $description;
    private string $image;
    private float  $tax;
    private Attribute $atributes;

    /**
     * Product constructor.
     */
    public function __construct()
    {
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
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     */
    public function setCategoryId(int $category_id): Product
    {
        $this->category_id = $category_id;
        return $this;
    }


    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): Product
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return float
     */
    public function getTax(): float
    {
        return $this->tax;
    }

    /**
     * @param float $tax
     */
    public function setTax(float $tax): Product
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return Attribute
     */
    public function getAtributes(): Attribute
    {
        return $this->atributes;
    }

    /**
     * @param Attribute $atributes
     */
    public function setAtributes(Attribute $atributes): Product
    {
        $this->atributes = $atributes;
        return $this;
    }


    static function createTent($category, $price, $name, $description, $image, $tax, $width, $height, $depth, $personAmount, $weight): Product
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("INSERT INTO PRODUCT SET  price =:price, name =:name ,id_category =:id_category, description =:description, image =:image, tax=:tax");
        $stmt->bindParam("id_category", $category);
        $stmt->bindParam("price", $price);
        $stmt->bindParam("name", $name);
        $stmt->bindParam("description", $description);
        $stmt->bindParam("tax", $tax);
        $stmt->bindParam("image", $image);

        Log::write_line($stmt->queryString);
        $stmt->execute();

        $id = $pdo->lastInsertId();
        $attributes = Attribute::createTent($id, $width, $height, $depth, $personAmount, $weight);

        $product = new Product();
        $product->setId($id)->setCategoryId($category)->setName($name)->setDescription($description)->setPrice(doubleval($price))->setTax($tax)->setAtributes($attributes);
        return $product;
    }
}