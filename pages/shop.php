<link rel="stylesheet" href="css/vertical_menu.css">
<link rel="stylesheet" href="css/shop.css">

<div class="shop-body">

    <?php use services\CartController;


    if (isset($_POST["action"]) && $_POST["action"] == "add") {
        CartController::addToCart($_POST["pid"]);
        unset($_POST["action"]);
        unset($_POST["pid"]);
    }

    include_once "pages/side_nav.php";

    if (isset($_GET["page"]) && $_GET["page"] == "detail") {
        include_once "pages/product_detail.php";
    } else {
        include_once "pages/products.php";
    }
    ?>


</div>