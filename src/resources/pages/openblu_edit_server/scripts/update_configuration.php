<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $OpenBlu  = new \OpenBlu\OpenBlu();
    $Server = $OpenBlu->getVPNManager()->getVPN(
        \OpenBlu\Abstracts\SearchMethods\VPN::byID, $_GET['id']
    );

    if(isset($_POST['configuration']))
    {
        $Server->ConfigurationParameters = json_decode($_POST['configuration']);
    }

    $OpenBlu->getVPNManager()->updateVPN($Server);
    header('Location: /openblu_edit_server?id=' . $_GET['id']);
    exit();