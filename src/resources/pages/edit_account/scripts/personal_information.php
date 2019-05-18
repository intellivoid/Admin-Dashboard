<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
    $IntellivoidAccounts = new \IntellivoidAccounts\IntellivoidAccounts();

    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(\IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byId, $_GET['id']);

    if(isset($_POST['first_name']))
    {
        $Account->PersonalInformation->FirstName = $_POST['first_name'];
    }

    if(isset($_POST['last_name']))
    {
        $Account->PersonalInformation->LastName = $_POST['last_name'];
    }

    if(isset($_POST['country']))
    {
        $Account->PersonalInformation->Country = $_POST['country'];
    }

    if(isset($_POST['phone_number']))
    {
        $Account->PersonalInformation->PhoneNumber = $_POST['phone_number'];
    }

    if(isset($_POST['bod_day']))
    {
        $Account->PersonalInformation->BirthDate->Day = (int)$_POST['bod_day'];
    }

    if(isset($_POST['bod_month']))
    {
        $Account->PersonalInformation->BirthDate->Month = (int)$_POST['bod_month'];
    }

    if(Isset($_POST['bod_year']))
    {
        $Account->PersonalInformation->BirthDate->Year = (int)$_POST['bod_year'];
    }

    $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
    header('Location: /edit_account?id=' . urlencode($_GET['id']));
    exit();