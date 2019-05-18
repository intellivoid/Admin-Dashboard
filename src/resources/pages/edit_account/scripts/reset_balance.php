<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
    $IntellivoidAccounts = new \IntellivoidAccounts\IntellivoidAccounts();

    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(\IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byId, $_GET['id']);
    $Account->Configuration->Balance = (float)0;
    $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
    header('Location: /edit_account?id=' . urlencode($_GET['id']));
    exit();