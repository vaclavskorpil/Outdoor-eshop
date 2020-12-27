<?php ?>
<h3 class="formTitle">Profil
    uživatele <? echo $user->getDeliveryInfo()->getName() . " " . $user->getDeliveryInfo()->getSurname() ?></h3>
<form method="post">
    <div class="input-group">
        <label>Jméno </label>
        <input name="name" type='text' required value=<? echo $user->getDeliveryInfo()->getName() ?> required/>
    </div>

    <div class="input-group">
        <input name="id" type='hidden' required value=<? echo $user->getId() ?>>
    </div>

    <div class="input-group">
        <label>Přijmení </label>
        <input name="surname" type="text" value=<? echo $user->getDeliveryInfo()->getSurname() ?> required/>
    </div>
    <div class="input-group">
        <label>Město </label>
        <input name="city" type="text" value=<? echo $user->getDeliveryInfo()->getCity() ?> required/>
    </div>
    <div class='input-group'>
        <label>Ulice </label>
        <input name='street' type='text' value=<? echo $user->getDeliveryInfo()->getStreet() ?> required/>
    </div>

    <div class='input-group'>
        <label>Číslo popisné </label>
        <input name='home_number' type='number'
               value=<? echo $user->getDeliveryInfo()->getHomeNumber() ?> required/>
    </div>

    <div class='input-group'>
        <label>PSČ </label>
        <input name='zip' type='number' value=<? echo $user->getDeliveryInfo()->getZip() ?> required/>
    </div>


    <div class='input-group'>
        <label>Telefonní číslo </label>
        <input name='phone_number' type='number' value=<? echo $user->getPhoneNumber() ?> required/>
    </div>


    <div class='row'>
        <input class='button'
               type='submit'
               value='Změmit údaje'
        >
    </div>