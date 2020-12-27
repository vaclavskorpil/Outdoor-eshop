<?php

namespace services;

use PDO;

class ProductRepository
{
    public static function getAllProductsByCategory(?int $category_id): array
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("WITH recursive all_cat as (
            select id, name, id_parent
            from CATEGORY
            where id = :id
            union all
            select cat.id, cat.name, cat.id_parent
            from CATEGORY cat,  all_cat sub_tree
            where cat.id_parent = sub_tree.id
                                )
            select p.*, atr.*, (p.price * (p.tax/100 +1)) as price_tax ,p.id as id 
            from all_cat a
            join PRODUCT p on p.id_category = a.id
            join ATTRIBUTE atr on atr.id = p.id_attribute"
        );
        $stmt->bindParam(':id', $category_id);
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
                    where id = :category_id
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

    public static function getAllCat(): array
    {

        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            " WITH recursive all_cat as (
    select cat.id, cat.name, cat.id_parent
    from CATEGORY cat
    where cat.id_parent is null
    union
    select c.id, c.name, c.id_parent
    from all_cat
             inner join CATEGORY c on all_cat.id = c.id_parent)
        select a.*, c.name as parent_name
           from all_cat a
         left join CATEGORY c on c.id = a.id_parent"
        );
        $stmt->bindParam(':category_id', $idCat);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById(int $pid): array
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT P.* FROM PRODUCT P LEFT JOIN ATTRIBUTE A ON A.ID = P.id_attribute WHERE P.ID =:pid "
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
    public static function getNormalById($pid): array
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
            "SELECT d.price FROM DELIVERY_METHOD d WHERE d.id =:did "
        );
        $stmt->bindParam(':did', $did);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)["price"];
    }

    public static function getPaymentPrice($pid): int
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "SELECT p.price FROM PAYMENT_METHOD p WHERE p.id =:pid "
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
                                     left join ATTRIBUTE a on p.id_attribute = a.id"
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

    public static function createProduct(int $idCategory, string $price, string $name, ?string $description, ?string $image, float $tax, int $idAttribute)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "insert into PRODUCT(id_category, price, name, description, image, tax, id_attribute)
                values (:id_category, :price , :name , :description, :image, :tax , :id_attribute)"
        );
        $stmt->bindParam(':id_category', $idCategory);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':tax', $tax);
        $stmt->bindParam(':id_attribute', $idAttribute);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    public static function createAttribute($width, $height, $depth, $temperature_max, $temperature_min, $volume, $amountOfPeople, $weight): int
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare(
            "insert into ATTRIBUTE(width, height, depth, temperature_max, temperature_min, volume, amount_of_people,  weight)
                values (:width, :height , :depth, :tempterature_max, :temperature_min, :volume, :amount_of_people , :weight)"
        );
        $stmt->bindParam(':width', $width);
        $stmt->bindParam(':height', $height);
        $stmt->bindParam(':depth', $depth);
        $stmt->bindParam(':tempterature_max', $temperature_max);
        $stmt->bindParam(':temperature_min', $temperature_min);
        $stmt->bindParam(':volume', $volume);
        $stmt->bindParam(':amount_of_people', $amountOfPeople);
        $stmt->bindParam(':weight', $weight);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    public static function deleteProduct($productId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("delete from PRODUCT where id = :id");
        $stmt->bindParam(':id', $productId);
        $stmt->execute();
    }

    public static function getAllRootCategories()
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("select * from CATEGORY where id_parent IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCategoriesOneLevelBellow($categoryid)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("select * from CATEGORY where id_parent = :categoryId");
        $stmt->bindParam(":categoryId", $categoryid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProductById($productId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("select a.*, p.* , (p.price * (p.tax/100 +1)) as price_tax from PRODUCT p join  ATTRIBUTE a on a.id = p.id_attribute where p.id = :id");
        $stmt->bindParam(':id', $productId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getNRandomProductsExcept($n, $exceptProductId): array
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("select a.*, p.*, (p.price * (p.tax / 100 + 1)) as price_tax, p.id as id
        from PRODUCT p
         join ATTRIBUTE a on a.id = p.id_attribute
        where p.id != :id_except
        order by RAND()
        limit 3 ");
        $stmt->bindParam(':id_except', $exceptProductId);
        // $stmt->bindParam(':n', $n); nevím proč ale když se snažím bindovat :n k limitu tak to padá
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRandomProducts(): array
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("select a.*, p.*, (p.price * (p.tax / 100 + 1)) as price_tax, p.id as id
        from PRODUCT p
         join ATTRIBUTE a on a.id = p.id_attribute
        order by RAND()
        limit 20 ");
        $stmt->bindParam(':id_except', $exceptProductId);
        // $stmt->bindParam(':n', $n); nevím proč ale když se snažím bindovat :n k limitu tak to padá
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}