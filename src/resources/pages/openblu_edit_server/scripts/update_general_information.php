<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $OpenBlu  = new \OpenBlu\OpenBlu();
    $Server = $OpenBlu->getVPNManager()->getVPN(
        \OpenBlu\Abstracts\SearchMethods\VPN::byID, $_GET['id']
    );

    if(isset($_POST['ip_address']))
    {
        $Server->IP = $_POST['ip_address'];
    }

    if(isset($_POST['host_name']))
    {
        $Server->HostName = $_POST['host_name'];
    }

    if(isset($_POST['country']))
    {
        $Server->Country = $_POST['country'];
    }

    if(isset($_POST['country_short']))
    {
        $Server->CountryShort = $_POST['country_short'];
    }

    if(isset($_POST['sessions']))
    {
        $Server->Sessions = (int)$_POST['sessions'];
    }

    if(isset($_POST['total_sessions']))
    {
        $Server->TotalSessions = (int)$_POST['total_sessions'];
    }

    if(isset($_POST['ping']))
    {
        $Server->Ping = (int)$_POST['ping'];
    }

    if(isset($_POST['score']))
    {
        $Server->Score = (int)$_POST['score'];
    }

    $OpenBlu->getVPNManager()->updateVPN($Server);
    header('Location: /openblu_edit_server?id=' . $_GET['id']);
    exit();