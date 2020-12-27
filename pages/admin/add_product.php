<link rel="stylesheet" href="css/order_form.css">
<link rel="stylesheet" href="css/responsive.css">
<?php ?>
<section class="main">
    <?php

    use entities\Category;
    use services\FileRepository;
    use services\ProductRepository;

    if (isset($_POST['name'])) {
        $filepath = null;
        if (isset($_FILES['file']['name'])) {
            $filepath = FileRepository::saveFile();
        }
        $name = $_POST["name"];
        $description = null;
        if (isset($_POST["description"]) && strlen($_POST["description"]) != 0) {
            $description = $_POST["description"];
        }
        $price = $_POST["price"];
        $tax = $_POST["tax"];
        $categoryId = $_POST["id_category"];



        $width = null;
        if (isset($_POST["width"]) && strlen($_POST["width"]) != 0) {
            $width = $_POST["width"];
        }

        $height = null;
        if (isset($_POST["height"]) && strlen($_POST["height"]) != 0) {
            $height = $_POST["height"];
        }

        $depth = null;
        if (isset($_POST["depth"]) && strlen($_POST["depth"]) != 0) {
            $depth = $_POST["depth"];
        }

        $temperature_max = null;
        if (isset($_POST["temperature_max"])&& strlen($_POST["temperature_max"]) != 0) {
            $temperature_max = $_POST["temperature_max"];
        }


        $temperature_min = null;
        if (isset($_POST["temperature_min"]) && strlen($_POST["temperature_min"]) != 0) {
            $temperature_min = $_POST["temperature_min"];
        }

        $volume = null;
        if (isset($_POST["volume"]) && strlen($_POST["volume"]) != 0) {
            $volume = $_POST["volume"];
        }


        $amount_of_people = null;
        if (isset($_POST["amount_of_people"])&& strlen($_POST["amount_of_people"]) != 0) {
            $amount_of_people = $_POST["amount_of_people"];
        }

        $weight = null;
        if (isset($_POST["weight"]) && strlen($_POST["weight"]) != 0) {
            $weight = $_POST["weight"];
        }

        $attributeId = ProductRepository::createAttribute($width, $height, $depth, $temperature_max, $temperature_min, $volume, $amount_of_people, $weight);
        ProductRepository::createProduct($categoryId, $price, $name, $description, $filepath, $tax, $attributeId);

    }
    ?>

    <form method="post" action="" enctype='multipart/form-data'>
        <label>Načti obrázek</label>
        <div>
            <input type='file' name='file' style="margin-bottom: 20px; margin-top: 20px">
        </div>

        <div class="input-group">
            <label>Název produktu</label>
            <input type='text' name='name' required>
        </div>
        <label>Popis</label>
        <div style="width: 95% ;height: 100px">
            <textarea class="textArea"
                      name="description"></textarea>
        </div>

        <div class="input-group">
            <label>Cena produktu [Kč]</label>
            <input type='number' name='price' required>
        </div>

        <div class="input-group">
            <label>Dph [%]</label>
            <input type='number' name='tax' required>
        </div>

        <label>Kategorie</label>
        <div>
            <select name="id_category">
                <?php
                $categories = ProductRepository::getAllCat();
                foreach ($categories as $cat):
                    ?>

                    <option value=<? echo $cat["id"] ?>><?
                        if (isset($cat['parent_name'])) {
                            echo $cat['parent_name'] . " - " . $cat["name"];;
                        } else {
                            echo $cat["name"];
                        }
                        ?></option>
                <? endforeach; ?>
            </select>

        </div>
        <div class="input-group">
            <label>Šířka [cm]</label>
            <input type='number' name='width'>
        </div>


        <div class="input-group">
            <label>Výška [cm]</label>
            <input type='number' name='height'>
        </div>


        <div class="input-group">
            <label>Hloubka [cm]</label>
            <input type='number' name='depth'>
        </div>


        <div class="input-group">
            <label>Maximální teplota [°C]</label>
            <input type='number' name='temperature_max'>
        </div>


        <div class="input-group">
            <label>Minimální teplota [°C]</label>
            <input type='number' name='temperature_min'>
        </div>


        <div class="input-group">
            <label>Obsah [l]</label>
            <input type='number' name='volume'>
        </div>

        <div class="input-group">
            <label>Váha [kg]</label>
            <input type='number' name='weight'>
        </div>

        <div class="input-group">
            <label>Počet lidí</label>
            <input type='number' name='amount_of_people'>
        </div>


        <input type='submit' value='Vytvoř produkt' name='but_upload'>

    </form>

</section>