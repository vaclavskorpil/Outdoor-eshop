<link rel="stylesheet" href="css/form.css">
<?php
if (AuthControler::isLoggedIn()):

    $email = $_SESSION[LOGGED_USER_EMAIL];
    if (isset($_GET["action"])) {
        $destination = ADMIN_CONTROLER;


        if (isset($_POST["email"]) && $_POST["email"] != "") {
            var_dump($_POST["email"]);
            $email = $_POST["email"];
        }
    }

    $me = UserControler::getUser($email);
    var_dump($me);
    $destination = PROFILE;

    if (isset($_POST["jmeno"])) {

        UserControler::updateUser($_POST["jmeno"], $_POST["prijmeni"], $_POST["email"], $_POST["ulice"], $_POST["mesto"], $_POST["cisloPopisne"], $_POST["psc"]);
    }

    ?>


    <section class="centeredContentWrapper">
        <h3 class="formTitle">Profil uživatele <? echo $me["jmeno"] . " " . $me["prijmeni"] ?></h3>
        <form action="?page=<? echo $destination ?>" method="post">
            <div class="input-group">
                <input name="jmeno" type='text' required value=<? echo $me["jmeno"] ?> required/>
                <label>Jméno </label>
            </div>
            <div class="input-group">
                <input name="email" type='hidden' required value=<? echo $email ?>>
            </div>

            <div class="input-group">
                <input name="prijmeni" type="text" value=<? echo $me["prijmeni"] ?> required/>

                <label>Přijmení </label>
            </div>
            <div class="input-group">
                <input name="mesto" type="text" value=<? echo $me["mesto"] ?> required/>
                <label>Město </label>
            </div>
            <div class='input-group'>
                <input name='ulice' type='text' value=<? echo $me["ulice"] ?> required/>
                <label>Ulice </label>
            </div>

            <div class='input-group'>
                <input name='cisloPopisne' type='number' value=<? echo $me["cislo_popisne"] ?> required/>
                <label>Číslo popisné </label>

                <div class='input-group'>
                    <input name='psc' type='number' value=<? echo $me["psc"] ?> required/>
                    <label>PSČ </label>
                </div>


                <div class='row'>
                    <input class='button'
                           type='submit'
                           value='Změmit údaje'
                    >
                </div>

        </form>
    </section>
<?php endif; ?>

