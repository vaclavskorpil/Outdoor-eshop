<link rel="stylesheet" href="css/form.css">
<link rel="stylesheet" href="css/message.css">
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jmeno = $_POST["jmeno"];
    $prijmeni = $_POST["prijmeni"];
    $email = $_POST["email"];
    $heslo = $_POST["heslo"];
    $mesto = $_POST["mesto"];
    $ulice = $_POST["ulice"];
    $cisloPopisne = $_POST["cisloPopisne"];
    $psc = $_POST["psc"];

    $success = AuthControler::register($jmeno, $prijmeni
        , $email, $heslo, $mesto,
        $ulice, $cisloPopisne, $psc);
    if (!$success) {
        $_SESSION[MESSAGE] = "Uživatel s tímto emailem je již registrován.";
    }
}

?>
<section class="centeredContentWrapper">
    <h3 class="formTitle">Registrace</h3>

    <?php
    if (isset($_SESSION[MESSAGE])) {
        echo "<p class='errMessage'>{$_SESSION[MESSAGE]}</p>";
        unset($_SESSION[MESSAGE]);
    }
    ?>

    <form action="?page=<?php echo REGISTER ?>" method="post">


        <div class="input-group">
            <input name="jmeno" type="text" required/>

            <label>Jméno </label>
        </div>

        <div class="input-group">
            <input name="prijmeni" type="text" required/>

            <label>Přijmení </label>
        </div>
        <div class="input-group">
            <input name="email" type="email" required/>
            <label>Email </label>

        </div>
        <div class="input-group">
            <input name="heslo" type="password" required/>
            <label>Heslo </label>
        </div>
        <div class="input-group">
            <input name="mesto" type="text" required/>
            <label>Město </label>
        </div>
        <div class="input-group">
            <input name="ulice" type="text" required/>
            <label>Ulice </label>
        </div>
        <div class="input-group">
            <input name="cisloPopisne" type="number" required/>
            <label>Číslo popisné </label>
        </div>
        <div class="input-group">
            <input name="psc" type="number" required/>
            <label>PSČ </label>
        </div>


        <div class="row">
            <input class="button"
                   type="submit"
                   value="Registrovat"
            >
        </div>

    </form>
</section>
