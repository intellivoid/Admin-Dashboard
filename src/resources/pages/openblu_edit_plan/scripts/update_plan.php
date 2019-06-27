<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $OpenBlu = new \OpenBlu\OpenBlu();
    $Plan = $OpenBlu->getPlanManager()->getPlan(\OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byId, $_GET['id']);

    if(isset($_POST['active']))
    {
        switch(strtolower($_POST['active']))
        {
            case '0':
                $Plan->Active = false;
                break;

            case '1':
                $Plan->Active = true;
                break;
        }
    }

    if(isset($_POST['payment_required']))
    {
        switch(strtolower($_POST['payment_required']))
        {
            case '0':
                $Plan->PaymentRequired = false;
                break;

            case '1':
                $Plan->PaymentRequired = true;
                break;
        }
    }

    if(isset($_POST['promotion_code']))
    {
        $Plan->PromotionCode = $_POST['promotion_code'];
    }

    if(isset($_POST['plan_started']))
    {
        switch(strtolower($_POST['plan_started']))
        {
            case '0':
                $Plan->PlanStarted = false;
                break;

            case '1':
                $Plan->PlanStarted = true;
                break;
        }
    }

    if(isset($_POST['plan_type']))
    {
        switch(strtolower($_POST['plan_type']))
        {
            case '0':
                $Plan->PlanType = \OpenBlu\Abstracts\APIPlan::Free;
                break;

            case '1':
                $Plan->PlanType = \OpenBlu\Abstracts\APIPlan::Basic;
                break;

            case '2':
                $Plan->PlanType = \OpenBlu\Abstracts\APIPlan::Enterprise;
                break;
        }
    }

    if(isset($_POST['price_per_cycle']))
    {
        $Plan->PricePerCycle = (float)$_POST['price_per_cycle'];
    }

    if(isset($_POST['monthly_calls']))
    {
        $Plan->MonthlyCalls = (int)$_POST['monthly_calls'];
    }

    if(isset($_POST['billing_cycle']))
    {
        $Plan->BillingCycle = (int)$_POST['billing_cycle'];
    }

    if(isset($_POST['next_billing_cycle']))
    {
        $Plan->NextBillingCycle = (int)$_POST['next_billing_cycle'];
    }

    if(isset($_POST['plan_created']))
    {
        $Plan->PlanCreated = (int)$_POST['plan_created'];
    }

    $OpenBlu->getPlanManager()->updatePlan($Plan);

    header('Location: /openblu_edit_plan?id=' . urlencode($_GET['id']));
    exit();