<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $OpenBlu = new \OpenBlu\OpenBlu();
    $Plan = $OpenBlu->getPlanManager()->getPlan(\OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byId, $_GET['id']);

    $OpenBlu->getPlanManager()->cancelPlan($Plan->AccountId);

    header('Location: /openblu_edit_plan?id=' . urlencode($_GET['id']));
    exit();