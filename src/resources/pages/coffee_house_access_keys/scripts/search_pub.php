<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');

    $ModularAPI = new \ModularAPI\ModularAPI();
    $AccessKey = $ModularAPI->AccessKeys()->Manager->get(\ModularAPI\Abstracts\AccessKeySearchMethod::byPublicID, $_GET['public_id']);

    header('Location: /coffee_house_edit_access_key?id=' . urlencode($AccessKey->ID));
    exit();