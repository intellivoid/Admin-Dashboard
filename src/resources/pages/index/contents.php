<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */

    use CoffeeHouse\CoffeeHouse;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\IntellivoidAccounts;
    use OpenBlu\OpenBlu;

    HTML::importScript('check_auth');
    HTML::importScript('require_auth');


    DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
    DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');
    DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $IntellivoidAccounts = new IntellivoidAccounts();
    $CoffeeHouse = new CoffeeHouse();
    $OpenBlu = new OpenBlu();

    function get_total_accounts(IntellivoidAccounts $intellivoidAccounts): int
    {
        $Results = $intellivoidAccounts->database->query("SELECT COUNT(*) AS total FROM `users`");
        $Row = $Results->fetch_array();
        return $Row['total'];
    }

    function get_total_api_requests(CoffeeHouse $coffeeHouse, OpenBlu $openBlu): int
    {
        $Results = $coffeeHouse->getDatabase()->query("SELECT COUNT(*) AS total FROM `requests`");
        $Row = $Results->fetch_array();
        $CoffeeHouseRequests = $Row['total'];

        $Results = $openBlu->database->query("SELECT COUNT(*) AS total FROM `requests`");
        $Rows = $Results->fetch_array();
        $OpenBluRequests = $Row['total'];

        return $CoffeeHouseRequests + $OpenBluRequests;
    }

    function get_total_ai_messages(CoffeeHouse $coffeeHouse): int
    {
        $Results = $coffeeHouse->getDatabase()->query("SELECT COUNT(*) AS total FROM `chat_dialogs`");
        $Row = $Results->fetch_array();
        return $Row['total'];
    }

    function get_total_ai_sessions(CoffeeHouse $coffeeHouse): int
    {
        $Results = $coffeeHouse->getDatabase()->query("SELECT COUNT(*) AS total FROM `foreign_sessions`");
        $Row = $Results->fetch_array();
        return $Row['total'];
    }

    function get_total_vpn_servers(OpenBlu $openblu): int
    {
        $Results = $openblu->database->query("SELECT COUNT(*) AS total FROM `vpns`");
        $Row = $Results->fetch_array();
        return $Row['total'];
    }

    function get_total_support_tickets(IntellivoidAccounts $intellivoidAccounts): int
    {
        $Results = $intellivoidAccounts->database->query("SELECT COUNT(*) AS total FROM `support_tickets`");
        $Row = $Results->fetch_array();
        return $Row['total'];
    }

    function get_ai_api_analytics(CoffeeHouse $coffeeHouse)
    {
        $Results = $coffeeHouse->getDatabase()->query("SELECT analytics FROM `access_keys`");
        $ResultsArray = array();
        while($Row = $Results->fetch_assoc())
        {
            $ResultsArray[] = unserialize($Row["analytics"]);
        }

        $ResultsAnalytics = null;

        foreach($ResultsArray as $AnalyticsRow)
        {
            if($ResultsAnalytics == null)
            {
                $ResultsAnalytics = $AnalyticsRow;
            }
            else
            {
                if($AnalyticsRow["last_month"]["available"] == true)
                {
                    $ResultsAnalytics["last_month"]["available"] = true;
                    foreach($AnalyticsRow["last_month"]["usage"] as $UsageDay => $value)
                    {
                        $ResultsAnalytics["last_month"]["usage"][$UsageDay] += $value;
                    }
                }

                if($AnalyticsRow["current_month"]["available"] == true)
                {
                    $ResultsAnalytics["current_month"]["available"] = true;
                    foreach($AnalyticsRow["current_month"]["usage"] as $UsageDay => $value)
                    {
                        $ResultsAnalytics["current_month"]["usage"][$UsageDay] += $value;
                    }
                }
            }
        }

        return $ResultsAnalytics;

    }

    function generateJs(array $data_in)
    {
        $Javascript = "Morris.Line({";
        $Javascript .= "element: 'api-usage-chart',";
        $Javascript .= "parseTime: false,";
        $Javascript .= "resize: true,";
        $Javascript .= "redraw: true,";
        $Javascript .= "lineColors: ['#0088cc', '#d53f3a', '#47a447', '#5bc0de'],";

        if($data_in["last_month"]["available"] == true)
        {
            $data = [];

            foreach($data_in["current_month"]["usage"] as $key => $value)
            {
                $data[$key]['day'] = $key +1;
                $data[$key]['day'] = (string)$data[$key]['day'];
                $data[$key]['current_month'] = $value;
            }

            foreach($data_in["last_month"]["usage"] as $key => $value)
            {
                $data[$key]['day'] = $key +1;
                $data[$key]['day'] = (string)$data[$key]['day'];
                $data[$key]['last_month'] = $value;
            }

            $Javascript .= "data: " . json_encode($data) . ",";
            $Javascript .= "xkey: \"day\",";
            $Javascript .= "ykeys: ['current_month', 'last_month'],";
            $Javascript .= "labels: ['Current Month Usage', 'Last Month Usage']";
        }
        else
        {
            $data = [];

            foreach($data_in["current_month"]["usage"] as $key => $value)
            {
                $data[$key]['day'] = $key +1;
                $data[$key]['day'] = (string)$data[$key]['day'];
                $data[$key]['current_month'] = $value;
            }

            $Javascript .= "data: " . json_encode($data) . ",";
            $Javascript .= "xkey: \"day\",";
            $Javascript .= "ykeys: ['current_month'],";
            $Javascript .= "labels: ['Current Month']";
        }


        $Javascript .= "});";

        print("<script>$Javascript</script>");
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
                            <span class="count_top"><i class="fa fa-arrow-circle-right"></i> Total API Requests</span>
                            <div class="count"><?PHP HTML::print(number_format(get_total_api_requests($CoffeeHouse, $OpenBlu))); ?></div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-comment"></i> Total AI Messages</span>
                            <div class="count"><?PHP HTML::print(number_format(get_total_ai_messages($CoffeeHouse))); ?></div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-comments"></i> Total AI Sessions</span>
                            <div class="count"><?PHP HTML::print(number_format(get_total_ai_sessions($CoffeeHouse))); ?></div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-server"></i> Total VPN Servers</span>
                            <div class="count"><?PHP HTML::print(number_format(get_total_vpn_servers($OpenBlu))); ?></div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-support"></i> Total Support Tickets</span>
                            <div class="count"><?PHP HTML::print(number_format(get_total_support_tickets($IntellivoidAccounts))); ?></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel tile">
                                <div class="x_title">
                                    <h2>CoffeeHouse API Usage</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="api-usage-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?PHP HTML::importSection('footer'); ?>

            </div>

        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <?PHP generateJs(get_ai_api_analytics($CoffeeHouse)); ?>
    </body>
</html>
