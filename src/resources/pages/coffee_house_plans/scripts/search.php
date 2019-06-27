<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');

    if(isset($_POST['search_method']) == false)
    {
        header('Location: /coffee_house_plans');
        exit();
    }

    if(isset($_POST['search_value']) == false)
    {
        header('Location: /coffee_house_plans');
        exit();
    }

    $SearchMethod = 'none';

    switch(strtolower($_POST['search_method']))
    {
        case \CoffeeHouse\Abstracts\PlanSearchMethod::byId:
            $SearchMethod = \CoffeeHouse\Abstracts\PlanSearchMethod::byId;
            break;

        case \CoffeeHouse\Abstracts\PlanSearchMethod::byAccessKeyId:
            $SearchMethod = \CoffeeHouse\Abstracts\PlanSearchMethod::byAccessKeyId;
            break;

        case \CoffeeHouse\Abstracts\PlanSearchMethod::byAccountId:
            $SearchMethod = \CoffeeHouse\Abstracts\PlanSearchMethod::byAccountId;
            break;

        default:
            header('Location: /coffee_house_plans');
            exit();
    }

    $CoffeeHouse = new \CoffeeHouse\CoffeeHouse();
    $Plan = $CoffeeHouse->getApiPlanManager()->getPlan($SearchMethod, $_POST['search_value']);

    header('Location: /coffee_house_edit_plan?id=' . urlencode($Plan->Id));
    exit();