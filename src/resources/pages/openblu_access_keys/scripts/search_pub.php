<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBu', 'OpenBlu', 'OpenBlu.php');

    $ModularAPI = new \ModularAPI\ModularAPI();
    $AccessKey = $ModularAPI->AccessKeys()->Manager->get(\ModularAPI\Abstracts\AccessKeySearchMethod::byPublicID, $_GET['public_id']);

    header('Location: /openblu_edit_access_key?id=' . urlencode($AccessKey->ID));
    exit();