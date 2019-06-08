<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    use sws\sws;

    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    $sws = new sws();
    $sws->WebManager()->disposeCookie('dashboard_session');
    header('Location: /');
    exit();