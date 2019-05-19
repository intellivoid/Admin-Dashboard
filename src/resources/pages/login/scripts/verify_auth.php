<?php

use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;
use sws\sws;

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST['authentication_code']))
        {

            try
            {
                DynamicalWeb::loadLibrary('sws', 'sws', 'sws.php');
            }
            catch (Exception $e)
            {
                header('Location: /500');
                exit();
            }

            $Auth = \DynamicalWeb\DynamicalWeb::getConfiguration('authentication');
            if(hash('sha256', $_POST['authentication_code']) !== hash('sha256', $Auth['AUTHENTICATION_CODE']))
            {
                header('Location: /login');
                exit();
            }

            $sws = new sws();
            $Cookie = $sws->WebManager()->getCookie('dashboard_session');
            $Cookie->Data['session_active'] = true;
            $sws->CookieManager()->updateCookie($Cookie);

            define('WEB_SESSION_ACTIVE', $Cookie->Data['session_active'], false);
            header('Location: /');
            exit();
        }
    }