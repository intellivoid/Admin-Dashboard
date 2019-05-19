<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBu', 'OpenBlu', 'OpenBlu.php');

    if(isset($_POST['search_method']) == false)
    {
        header('Location: /openblu_access_keys');
        exit();
    }

    if(isset($_POST['search_value']) == false)
    {
        header('Location: /openblu_access_keys');
        exit();
    }

    $SearchMethod = 'none';

    switch(strtolower($_POST['search_method']))
    {
        case \ModularAPI\Abstracts\AccessKeySearchMethod::byID:
            $SearchMethod = \ModularAPI\Abstracts\AccessKeySearchMethod::byID;
            break;

        case \ModularAPI\Abstracts\AccessKeySearchMethod::byPublicID:
            $SearchMethod = \ModularAPI\Abstracts\AccessKeySearchMethod::byPublicID;
            break;

        case \ModularAPI\Abstracts\AccessKeySearchMethod::byPublicKey:
            $SearchMethod = \ModularAPI\Abstracts\AccessKeySearchMethod::byPublicKey;
            break;

        default:
            header('Location: /openblu_access_keys');
            exit();
    }

    $ModularAPI = new \ModularAPI\ModularAPI();
    $AccessKey = $ModularAPI->AccessKeys()->Manager->get($SearchMethod, $_POST['search_value']);

    header('Location: /openblu_edit_access_key?id=' . urlencode($AccessKey->ID));
    exit();