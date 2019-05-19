<?php


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST['authentication_code']))
        {
            $Auth = \DynamicalWeb\DynamicalWeb::getConfiguration('authentication');
            if(hash('sha256', $_POST['authentication_code']) !== hash('sha256', $Auth['AUTHENTICATION_CODE']))
            {
                header('Location: /login');
                exit();
            }

            setcookie('authentication', $_POST['authentication_code'], 1800);
            header('Location: /');
            exit();
        }
    }