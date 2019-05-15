<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBu', 'OpenBlu', 'OpenBlu.php');

    if(isset($_POST['search_method']) == false)
    {
        header('Location: /openblu_servers');
        exit();
    }

    if(isset($_POST['search_value']) == false)
    {
        header('Location: /openblu_servers');
        exit();
    }

    $SearchMethod = 'none';

    switch(strtolower($_POST['search_method']))
    {
        case \OpenBlu\Abstracts\SearchMethods\VPN::byID:
            $SearchMethod = \OpenBlu\Abstracts\SearchMethods\VPN::byID;
            break;

        case \OpenBlu\Abstracts\SearchMethods\VPN::byPublicID:
            $SearchMethod = \OpenBlu\Abstracts\SearchMethods\VPN::byPublicID;
            break;

        case \OpenBlu\Abstracts\SearchMethods\VPN::byIP:
            $SearchMethod = \OpenBlu\Abstracts\SearchMethods\VPN::byIP;
            break;

        default:
            header('Location: /openblu_servers');
            exit();
    }

    $OpenBlu = new \OpenBlu\OpenBlu();
    $Server = $OpenBlu->getVPNManager()->getVPN($SearchMethod , $_POST['search_value']);

    header('Location: /openblu_edit_server?id=' . urlencode($Server->ID));
    exit();