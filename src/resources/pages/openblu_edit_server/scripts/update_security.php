<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $OpenBlu  = new \OpenBlu\OpenBlu();
    $Server = $OpenBlu->getVPNManager()->getVPN(
        \OpenBlu\Abstracts\SearchMethods\VPN::byID, $_GET['id']
    );

    if(isset($_POST['certificate']))
    {
        $Server->Certificate = $_POST['certificate'];
    }

    if(isset($_POST['certificate_authority']))
    {
        $Server->CertificateAuthority = $_POST['certificate_authority'];
    }

    if(isset($_POST['key']))
    {
        $Server->Key = $_POST['key'];
    }

    $OpenBlu->getVPNManager()->updateVPN($Server);
    header('Location: /openblu_edit_server?id=' . $_GET['id']);
    exit();