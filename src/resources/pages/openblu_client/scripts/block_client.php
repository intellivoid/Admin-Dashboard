<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $OpenBlu = new \OpenBlu\OpenBlu();

    $Client = $OpenBlu->getClientManager()->getClient(\OpenBlu\Abstracts\SearchMethods\ClientSearchMethod::byId, $_GET['id']);
    $Client->Blocked = true;

    $OpenBlu->getClientManager()->updateClient($Client);

    header('Location: /openblu_client?id=' . urlencode($_GET['id']));
    exit();