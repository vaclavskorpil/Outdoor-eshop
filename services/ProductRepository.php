<?php

namespace services;

use PDO;

class ProductRepository
{
    public static function getAllProductsByCategory(?int $category_id): array
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("WITH recursive all_prod as (
                                        select p.*,
                                               a.width,
                                               a.height,
                                               a.depth,
                                               a.id as id_attribute,
                                               a.temperature_max,
                                               a.temperature_min,
                                               a.volume,
                                               a.amount_of_people,
                                               c.id_parent,
                                               (p.price * (p.tax/100 +1)) as price_tax
                                        from PRODUCT p
                                                 inner join CATEGORY c on p.id_category = c.id
                                                 left join ATTRIBUTE a on p.id = a.id_product
                                        where id_category = :category_id
                                        union
                                        select p.*,
                                               a.width,
                                               a.height,
                                               a.depth,
                                               a.id as id_attribute,
                                               a.temperature_max,
                                               a.temperature_min,
                                               a.volume,
                                               a.amount_of_people,
                                               c.id_parent,
                                               (p.price * (p.tax/100 +1)) as price_tax
                                        from all_prod
                                                 inner join CATEGORY c on all_prod.id_category = c.id_parent
                                                 inner join PRODUCT p on p.id_category = c.id
                                                 left join ATTRIBUTE a on p.id = a.id_product
                                    )
                                    select *
                                    from all_prod"
        );
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function getAllChildCat($idCat): array
    {

        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            " WITH recursive all_cat as (
                    select c.id, c.name, c.id_parent
                    from CATEGORY c
                    where id = 4
                    union
                    select c.id, c.name, c.id_parent
                    from all_cat
                    inner join CATEGORY c on all_cat.id = c.id_parent)
                    select *
                     from all_cat"
        );
        $stmt->bindParam(':category_id', $idCat);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById(int $pid): array
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT P.* FROM PRODUCT P LEFT JOIN ATTRIBUTE A ON A.ID_PRODUCT = P.ID WHERE P.ID =:pid "
        );
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /** @return array [name] [price](with tax) of product */
    public static function getTinyById(int $pid): array
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT P.name , (P.price*(P.tax/100 +1)) as price FROM PRODUCT P WHERE P.ID =:pid "
        );
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** @return array [name] [price] [price_tax] [tax] [image] of product */
    public static function getNormalById(int $pid): array
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT P.name ,P.price, (P.price*(P.tax/100 +1)) as price_tax, P.tax, P.image FROM PRODUCT P WHERE P.ID =:pid "
        );
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getDeliveryPrice($did): int
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT d.price FROM delivery_method d WHERE d.id =:did "
        );
        $stmt->bindParam(':did', $did);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)["price"];
    }

    public static function getPaymentPrice($pid): int
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT p.price FROM payment_method p WHERE p.id =:pid "
        );
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)["price"];
    }

    /* public static function getChosenDelivery(): int
     {
         if (isset($_SESSION["deliveryId"])) {
             return;
         }
     }*/


    public static function createOrderedProduct(int $orderId, int $productId, int $quantity)
    {
        $product = self::getById($productId);

        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "INSERT INTO ORDERED_PRODUCT ( id_product , price , tax , id_order ,  quantity )
                        VALUES (:id_product, :price , :tax , :id_order , :quantity)"
        );
        $stmt->bindParam(':id_product', $productId);
        $stmt->bindParam(':price', $product["price"]);
        $stmt->bindParam(':tax', $product["tax"]);
        $stmt->bindParam(':id_order', $orderId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    }

    public static function getAllOrderProducts(int $orderId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "select o.quantity ,(o.price * (o.tax/100+1)) as price , p.name from ORDERED_PRODUCT o left join PRODUCT p on p.id = o.id_product where id_order = :orderId"
        );
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllProducts()
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "            select p.*,
                                   a.width,
                                   a.height,
                                   a.depth,
                                   a.id as id_attribute,
                                   a.temperature_max,
                                   a.temperature_min,
                                   a.volume,
                                   a.amount_of_people,
                                   c.id_parent,
                                
                                   (p.price * (p.tax/100 +1)) as price_tax
                            from PRODUCT p
                                     inner join CATEGORY c on p.id_category = c.id
                                     left join ATTRIBUTE a on p.id = a.id_product"
        );
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** returns array [name] [parent_name]*/
    public static function getCategoryNames(int $categoryId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "    select  c.name,(select b.name from CATEGORY b where b.id = c.id_parent ) as parent_name  from CATEGORY c where c.id = :id;
        ");
        $stmt->bindParam(':id', $categoryId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}