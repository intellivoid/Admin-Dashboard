<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
    $IntellivoidAccounts = new \IntellivoidAccounts\IntellivoidAccounts();

    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(\IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byId, $_GET['id']);

    if(isset($_POST['email']))
    {
        $Account->Email = $_POST['email'];
    }

    if(isset($_POST['status']))
    {
        switch($_POST['status'])
        {
            case '0':
                $Account->Status = \IntellivoidAccounts\Abstracts\AccountStatus::Active;
                break;

            case '1':
                $Account->Status = \IntellivoidAccounts\Abstracts\AccountStatus::Suspended;
                break;

            case '2':
                $Account->Status = \IntellivoidAccounts\Abstracts\AccountStatus::Limited;
                break;

            case '3':
                $Account->Status = \IntellivoidAccounts\Abstracts\AccountStatus::VerificationRequired;
                break;
        }
    }

    $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

    header('Location: /edit_account?id=' . urlencode($_GET['id']));
    exit();