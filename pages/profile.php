<link rel="stylesheet" href="css/order_form.css">
<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/basic_table.css">
<?php

use services\AuthController;
use services\DeliveryRepository;
use services\OrderRepository;

if (AuthController::isLoggedIn()):

    $id = $_SESSION[USER_ID];
    $destination = PROFILE;

    if (isset($_GET["action"])) {
        $destination = ADMIN_CONTROLER;
        $id = $_POST["id"];
    }
    if (isset($_POST["name"])) {
        header("Location: ?page=$destination");
    }
    if (isset($_POST["newpass"])) {
        UserRepository::changeUserPass($id, $_POST["newpass"]);
    }


    $user = UserRepository::getUserById($id);
    ?>


    <section class="main">
        <h2>
            Profil uživatele
        </h2>
        <div>
            <div id="user-email">Email: <? echo $user["email"] ?></div>
            <div id="pass-validation-text" class="error-text"></div>
            <div id="change-password-div">
                <form method="post">
                    <label>Nové heslo
                        <input id="new-password" name="newpass" type="text">
                    </label>
                    <label>
                        Zadejte nové heslo znovu
                        <input id="pass-again" type="text" onkeyup="passValidation()">
                    </label>
                    <input id="save-pass-btn" type="submit" value="Ulož heslo">
                </form>
            </div>
            <button id="change-pass-btn" class="basic-button"
                    onclick="showChangePassDialog()">Změň heslo
            </button>
        </div>
        <h3>Dodací info</h3>
        <? $deliveryInfo = UserRepository::getUsersDeliveryInfo($id); ?>
        <div class="delivery-info-block">
            <? foreach ($deliveryInfo as $info): ?>
                <div class="delivery-info-card">
                    <div>
                        Jméno: <? echo $info["name"] ?>
                    </div>
                    <div>
                        Příjmení: <? echo $info["surname"] ?>
                    </div>

                    <div>
                        Kontaktní email: <? echo $info["email"] ?>
                    </div>
                    <div>
                        Telefonní číslo: <? echo $info["phone_number"] ?>
                    </div>

                    <div>
                        Adresa:
                    </div>

                    <div>
                        <? echo $info["street"] . " " . $info["home_number"] ?>
                    </div>
                    <div>
                        <? echo $info["zip"] . " " . $info["city"] ?>
                    </div>

                </div>
            <? endforeach; ?>

        </div>
        <h2>Mé objednávky</h2>
        <?php


        if (isset($_SESSION[USER_ID])):
        $orders = OrderRepository::getUserOrders($_SESSION[USER_ID]);
        ?>
        <? if (sizeof($orders) != 0): ?>
            <div class="overflow">
                <table class="basic-table">

                    <thead>
                    <tr>
                        <th> Číslo objednávky</th>
                        <th> Stav objednávky</th>
                        <th> Datum objednání</th>
                        <th> Celková cena</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($orders as $order): ?>


                        <tr>
                            <td>
                                <a href="?page=order_detail&orderId=<? echo $order["id"] ?>">   <? echo $order["id"] ?> </a>
                            </td>
                            <td>
                                <a href="?page=order_detail&orderId=<? echo $order["id"] ?>"><? echo $order["status"] ?></a>
                            </td>
                            <td>
                                <a href="?page=order_detail&orderId=<? echo $order["id"] ?>"><? echo $order["order_datetime"] ?></a>
                            </td>
                            <td><a href="?page=order_detail&orderId=<? echo $order["id"] ?>"><? echo $order["price"] ?>
                                    Kč</a></td>

                        </tr>


                    <? endforeach; ?>
                    </tbody>

                </table>
            </div>;
        <?php else: ?>

            <h3>
                Nemáte žádné objednávky.
            </h3>
        <?php endif; ?>
    </section>

    <script>

        function showChangePassDialog() {
            document.getElementById('change-password-div').style.display = 'block'
            document.getElementById('change-pass-btn').style.display = 'none'
        }

        function passValidation() {
            let newPass = document.getElementById("new-password").value;
            let newPassAgain = document.getElementById("pass-again").value;
            if (newPass.length > 0) {
                if (newPass === newPassAgain) {
                    document.getElementById("save-pass-btn").style.display = 'block';
                    document.getElementById("pass-validation-text").style.color = '#00ff00';
                    document.getElementById("pass-validation-text").innerHTML = "Hesla jsou stejná";
                } else {
                    document.getElementById("save-pass-btn").style.display = 'none';
                    document.getElementById("pass-validation-text").innerHTML = "Hesla nejsou stejná";
                    document.getElementById("pass-validation-text").style.color = '#ff0000';
                }
            }
        }

    </script>
<?php endif; ?>
<?php endif; ?>

