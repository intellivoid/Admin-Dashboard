<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
    $IntellivoidAccounts = new \IntellivoidAccounts\IntellivoidAccounts();

    switch($_POST['transaction_type'])
    {
        case '0':
            $IntellivoidAccounts->getTransactionRecordManager()->createTransaction(
                (int)$_GET['id'], (float)$_POST['amount'], $_POST['vendor'],
                \IntellivoidAccounts\Abstracts\TransactionType::Payment
            );
            break;

        case '1':
            $IntellivoidAccounts->getTransactionRecordManager()->createTransaction(
                (int)$_GET['id'], (float)$_POST['amount'], $_POST['vendor'],
                \IntellivoidAccounts\Abstracts\TransactionType::SubscriptionPayment
            );
            break;

        case '2':
            $IntellivoidAccounts->getTransactionRecordManager()->createTransaction(
                (int)$_GET['id'], (float)$_POST['amount'], $_POST['vendor'],
                \IntellivoidAccounts\Abstracts\TransactionType::Deposit
            );
            break;

        case '3':
            $IntellivoidAccounts->getTransactionRecordManager()->createTransaction(
                (int)$_GET['id'], (float)$_POST['amount'], $_POST['vendor'],
                \IntellivoidAccounts\Abstracts\TransactionType::Withdraw
            );
            break;

        case '4':
            $IntellivoidAccounts->getTransactionRecordManager()->createTransaction(
                (int)$_GET['id'], (float)$_POST['amount'], $_POST['vendor'],
                \IntellivoidAccounts\Abstracts\TransactionType::Refund
            );
            break;
    }

    header('Location: /edit_account?id=' . urlencode($_GET['id']));
    exit();