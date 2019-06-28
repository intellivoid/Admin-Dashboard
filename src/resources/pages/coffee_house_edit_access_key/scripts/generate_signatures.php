<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');
    $CoffeeHouse = new \CoffeeHouse\CoffeeHouse();

    $Plan = $CoffeeHouse->getApiPlanManager()->getPlan(\CoffeeHouse\Abstracts\PlanSearchMethod::byId, $_GET['id']);
    $CoffeeHouse->getApiPlanManager()->updateSignatures($Plan);

    header('Location: /coffee_house_edit_access_key?id=' . urlencode($_GET['id']));
    exit();