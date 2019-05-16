<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $OpenBlu = new \OpenBlu\OpenBlu();
    $Plan = $OpenBlu->getPlanManager()->getPlan(\OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byId, $_GET['id']);

    $PlanType = null;
    if(isset($_POST['plan_type']))
    {
        switch(strtolower($_POST['plan_type']))
        {
            case '0':
                $PlanType = \OpenBlu\Abstracts\APIPlan::Free;
                break;

            case '1':
                $PlanType = \OpenBlu\Abstracts\APIPlan::Basic;
                break;

            case '2':
                $PlanType = \OpenBlu\Abstracts\APIPlan::Enterprise;
                break;

            default:
                header('Location: /openblu_edit_plan?id=' . urlencode($_GET['id']));
                exit();
        }
    }
    else
    {
        header('Location: /openblu_edit_plan?id=' . urlencode($_GET['id']));
        exit();
    }

    $MonthlyCalls = 0;
    if(isset($_POST['monthly_calls']))
    {
        $MonthlyCalls = (int)$_POST['monthly_calls'];
    }
    else
    {
        header('Location: /openblu_edit_plan?id=' . urlencode($_GET['id']));
        exit();
    }

    $BillingCycle = 0;
    if(isset($_POST['billing_cycle']))
    {
        $BillingCycle = (int)$_POST['billing_cycle'];
    }
    else
    {
        header('Location: /openblu_edit_plan?id=' . urlencode($_GET['id']));
        exit();
    }

    $PricePerCycle = 0;
    if(isset($_POST['price_per_cycle']))
    {
        $PricePerCycle = (int)$_POST['price_per_cycle'];
    }
    else
    {
        header('Location: /openblu_edit_plan?id=' . urlencode($_GET['id']));
        exit();
    }

    $PromotionCode = 'NORMAL';
    if(isset($_POST['promotion_code']))
    {
        $PromotionCode = $_POST['promotion_code'];
    }
    else
    {
        header('Location: /openblu_edit_plan?id=' . urlencode($_GET['id']));
        exit();
    }


    $OpenBlu->getPlanManager()->startPlan(
        $Plan->AccountId,
        $PlanType,
        $MonthlyCalls,
        $BillingCycle,
        $PricePerCycle,
        $PromotionCode
    );

    header('Location: /openblu_edit_plan?id=' . urlencode($_GET['id']));
    exit();