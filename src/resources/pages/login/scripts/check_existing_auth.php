<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use sws\sws;

    try
    {
        DynamicalWeb::loadLibrary('sws', 'sws', 'sws.php');
    }
    catch (Exception $e)
    {
        header('Location: /500');
        exit();
    }

    $sws = new sws();

    if($sws->WebManager()->isCookieValid('dashboard_session') == false)
    {
        $Cookie = $sws->CookieManager()->newCookie('dashboard_session', 86400, false);

        $Cookie->Data = array(
            'session_active' => false,
        );

        $sws->CookieManager()->updateCookie($Cookie);
        $sws->WebManager()->setCookie($Cookie);

        if($Cookie->Name == null)
        {
            print('There was an issue with the security check, Please refresh the page');
            exit();
        }

        header('Refresh: 2; URL=/');
        print('Loading WebApp Resources ...');
        exit();

    }

    $Cookie = $sws->WebManager()->getCookie('dashboard_session');

    define('WEB_SESSION_ACTIVE', $Cookie->Data['session_active'], false);