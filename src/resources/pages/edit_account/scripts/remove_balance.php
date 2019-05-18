<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
    $IntellivoidAccounts = new \IntellivoidAccounts\IntellivoidAccounts();

    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(\IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byId, $_GET['id']);

    $Balance = (float)$Account->Configuration->Balance;

    if(isset($_POST['balance']))
    {
        $RequestedBalance = (float)$_POST['balance'];
        if($RequestedBalance > 0)
        {
            $Balance -= $RequestedBalance;
        }
    }

    if($Balance < 0)
    {
        $Balance = (float)0;
    }

    $Account->Configuration->Balance = $Balance;
    $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
    header('Location: /edit_account?id=' . urlencode($_GET['id']));
    exit();