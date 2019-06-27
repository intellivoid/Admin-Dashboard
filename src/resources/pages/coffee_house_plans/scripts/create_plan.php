<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');

    $CoffeeHouse = new \CoffeeHouse\CoffeeHouse();

    $PlanType = null;
    if(isset($_POST['plan_type']))
    {
        switch(strtolower($_POST['plan_type']))
        {
            case '0':
                $PlanType = \CoffeeHouse\Abstracts\APIPlan::Free;
                break;

            case '1':
                $PlanType = \CoffeeHouse\Abstracts\APIPlan::Basic;
                break;

            case '2':
                $PlanType = \CoffeeHouse\Abstracts\APIPlan::Enterprise;
                break;

            default:
                header('Location: /coffee_house_plans');
                exit();
        }
    }
    else
    {
        header('Location: /coffee_house_plans');
        exit();
    }

    $MonthlyCalls = 0;
    if(isset($_POST['monthly_calls']))
    {
        $MonthlyCalls = (int)$_POST['monthly_calls'];
    }
    else
    {
        header('Location: /coffee_house_plans');
        exit();
    }

    $BillingCycle = 0;
    if(isset($_POST['billing_cycle']))
    {
        $BillingCycle = (int)$_POST['billing_cycle'];
    }
    else
    {
        header('Location: /coffee_house_plans');
        exit();
    }

    $PricePerCycle = 0;
    if(isset($_POST['price_per_cycle']))
    {
        $PricePerCycle = (int)$_POST['price_per_cycle'];
    }
    else
    {
        header('Location: /coffee_house_plans');
        exit();
    }

    $PromotionCode = 'NORMAL';
    if(isset($_POST['promotion_code']))
    {
        $PromotionCode = $_POST['promotion_code'];
    }
    else
    {
        header('Location: /coffee_house_plans');
        exit();
    }


    $CreatedPlan = $CoffeeHouse->getApiPlanManager()->startPlan(
        (int)$_POST['account_id'],
        $PlanType,
        $MonthlyCalls,
        $BillingCycle,
        $PricePerCycle,
        $PromotionCode
    );

    header('Location: /coffee_house_edit_plan?id=' . urlencode($CreatedPlan->Id));
    exit();