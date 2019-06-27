<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');

    $CoffeeHouse = new \CoffeeHouse\CoffeeHouse();
    $Plan = $CoffeeHouse->getApiPlanManager()->getPlan(\CoffeeHouse\Abstracts\PlanSearchMethod::byId, $_GET['id']);
    $CoffeeHouse->getApiPlanManager()->cancelPlan($Plan->AccountId);

    header('Location: /coffee_house_edit_plan?id=' . urlencode($_GET['id']));
    exit();