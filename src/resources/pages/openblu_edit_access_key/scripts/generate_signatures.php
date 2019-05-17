<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $OpenBlu = new \OpenBlu\OpenBlu();

    $Plan = $OpenBlu->getPlanManager()->getPlan(\OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byAccessKeyId, $_GET['id']);
    $OpenBlu->getPlanManager()->updateSignatures($Plan);

    header('Location: /openblu_edit_access_key?id=' . urlencode($_GET['id']));
    exit();