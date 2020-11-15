<?php

namespace entities;

use PDO;
use services\Connection;

class Category
{
    private int $id;
    private string $name;
    private ?int $id_parent;
    private array $children;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->children = [];
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
    public function setId(int $id): void
    {
        $this->id = $id;
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
    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdParent(): int
    {
        return $this->id_parent;
    }

    /**
     * @param int $id_parent
     */
    public function setIdParent(?int $id_parent): Category
    {
        $this->id_parent = $id_parent;
        return $this;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param array $children
     */
    public function setChildren(array $children): Category
    {
        $this->children = $children;
        return $this;
    }


    public function loadFromRow($categoryRow)
    {
        $this->setName($categoryRow["name"])->setIdParent($categoryRow["id_parent"])->setId($categoryRow["id"]);
    }


    private static function loadChildren(Category $parent)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT * FROM CATEGORY where id_parent = :id_parent");
        $idParent = $parent->getId();
        $stmt->bindParam('id_parent', $idParent);
        $stmt->execute();
        $catRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($catRows as $row) {
            $category = new Category();
            $category->loadFromRow($row);
            array_push($parent->children, $category);
            self::loadChildren($category);
        }
    }

    public static function getAll(): array
    {

        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT * FROM CATEGORY where id_parent is null");
        $stmt->execute();
        $catRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach ($catRows as $row) {
            $category = new Category();
            $category->loadFromRow($row);
            array_push($categories, $category);
            self::loadChildren($category);
        }
        return $categories;
    }

}