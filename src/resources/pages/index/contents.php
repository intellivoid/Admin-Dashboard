<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');


    \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');
    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $IntellivoidAccounts = new \IntellivoidAccounts\IntellivoidAccounts();
    $CoffeeHouse = new \CoffeeHouse\CoffeeHouse();
    $OpenBlu = new \OpenBlu\OpenBlu();

    function get_total_accounts(\IntellivoidAccounts\IntellivoidAccounts $intellivoidAccounts): int
    {
        $Results = $intellivoidAccounts->database->query("SELECT COUNT(*) AS total FROM `users`");
        $Row = $Results->fetch_array();
        return $Row['total'];
    }

    function get_total_api_requests(\CoffeeHouse\CoffeeHouse $coffeeHouse, \OpenBlu\OpenBlu $openBlu): int
    {
        $Results = $coffeeHouse->getDatabase()->query("SELECT COUNT(*) AS total FROM `requests`");
        $Row = $Results->fetch_array();
        $CoffeeHouseRequests = $Row['total'];

        $Results = $openBlu->database->query("SELECT COUNT(*) AS total FROM `requests`");
        $Rows = $Results->fetch_array();
        $OpenBluRequests = $Row['total'];

        return $CoffeeHouseRequests + $OpenBluRequests;
    }

    function get_total_ai_messages(\CoffeeHouse\CoffeeHouse $coffeeHouse): int
    {
        $Results = $coffeeHouse->getDatabase()->query("SELECT COUNT(*) AS total FROM `chat_dialogs`");
        $Row = $Results->fetch_array();
        return $Row['total'];
    }

    function get_total_ai_sessions(\CoffeeHouse\CoffeeHouse $coffeeHouse): int
    {
        $Results = $coffeeHouse->getDatabase()->query("SELECT COUNT(*) AS total FROM `foreign_sessions`");
        $Row = $Results->fetch_array();
        return $Row['total'];
    }

    function get_total_vpn_servers(\OpenBlu\OpenBlu $openblu): int
    {
        $Results = $openblu->database->query("SELECT COUNT(*) AS total FROM `vpns`");
        $Row = $Results->fetch_array();
        return $Row['total'];
    }

    function get_total_support_tickets(\IntellivoidAccounts\IntellivoidAccounts $intellivoidAccounts): int
    {
        $Results = $intellivoidAccounts->database->query("SELECT COUNT(*) AS total FROM `support_tickets`");
        $Row = $Results->fetch_array();
        return $Row['total'];
    }
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('header'); ?>
        <title>Intellivoid Admin</title>
    </head>

    <body class="nav-md">
        <div class="container body">

            <div class="main_container">

                <?PHP HTML::importSection('sideview'); ?>
                <?PHP HTML::importSection('navigation'); ?>

                <div class="right_col" role="main">
                    <div class="row tile_count">
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
                            <div class="count"><?PHP HTML::print(number_format(get_total_accounts($IntellivoidAccounts))); ?></div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-clock-o"></i> Total API Requests</span>
                            <div class="count"><?PHP HTML::print(number_format(get_total_api_requests($CoffeeHouse, $OpenBlu))); ?></div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Total AI Messages</span>
                            <div class="count green"><?PHP HTML::print(number_format(get_total_ai_messages($CoffeeHouse))); ?></div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Total AI Sessions</span>
                            <div class="count"><?PHP HTML::print(number_format(get_total_ai_sessions($CoffeeHouse))); ?></div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Total VPN Servers</span>
                            <div class="count"><?PHP HTML::print(number_format(get_total_vpn_servers($OpenBlu))); ?></div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Total Support Tickets</span>
                            <div class="count"><?PHP HTML::print(number_format(get_total_support_tickets($IntellivoidAccounts))); ?></div>
                        </div>
                    </div>
                </div>

                <?PHP HTML::importSection('footer'); ?>

            </div>

        </div>

        <?PHP HTML::importSection('js_scripts'); ?>
    </body>
</html>
