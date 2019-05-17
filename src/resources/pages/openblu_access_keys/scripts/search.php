<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBu', 'OpenBlu', 'OpenBlu.php');

    if(isset($_POST['search_method']) == false)
    {
        header('Location: /openblu_plans');
        exit();
    }

    if(isset($_POST['search_value']) == false)
    {
        header('Location: /openblu_plans');
        exit();
    }

    $SearchMethod = 'none';

    switch(strtolower($_POST['search_method']))
    {
        case \OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byId:
            $SearchMethod = \OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byId;
            break;

        case \OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byAccessKeyId:
            $SearchMethod = \OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byAccessKeyId;
            break;

        case \OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byAccountId:
            $SearchMethod = \OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byAccountId;
            break;

        default:
            header('Location: /openblu_plans');
            exit();
    }

    $OpenBlu = new \OpenBlu\OpenBlu();
    $Plan = $OpenBlu->getPlanManager()->getPlan($SearchMethod, $_POST['search_value']);

    header('Location: /openblu_edit_plan?id=' . urlencode($Plan->Id));
    exit();