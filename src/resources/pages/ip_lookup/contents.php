<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IPStack\IPStack;

    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    DynamicalWeb::loadLibrary('IPStack', 'IPStack', 'IPStack.php');
    $Configuration = DynamicalWeb::getConfiguration('configuration');
    $IPStack = new IPStack(
        $Configuration['ip_stack']['access_key'],
        $Configuration['ip_stack']['use_ssl'],
        $Configuration['ip_stack']['host']
    );

    $IPAddress = $IPStack->lookup($_GET['ip']);

    function fancy_print($input)
    {
        if($input == null)
        {
            HTML::print('N/A');
            return;
        }

        HTML::print((string)$input);
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
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>IP Lookup</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Property</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>IP Address</td>
                                                <td><?PHP fancy_print($IPAddress->IP); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Zip Code</td>
                                                <td><?PHP fancy_print($IPAddress->Zip); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Continent Name</td>
                                                <td><?PHP fancy_print($IPAddress->ContinentName); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Continent Code</td>
                                                <td><?PHP fancy_print($IPAddress->ContinentCode); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Country Name</td>
                                                <td><?PHP fancy_print($IPAddress->CountryName); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Country Code</td>
                                                <td><?PHP fancy_print($IPAddress->CountryCode); ?></td>
                                            </tr>
                                            <tr>
                                                <td>City</td>
                                                <td><?PHP fancy_print($IPAddress->City); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Longitude</td>
                                                <td><?PHP fancy_print($IPAddress->Longitude); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Latitude</td>
                                                <td><?PHP fancy_print($IPAddress->Latitude); ?></td>
                                            </tr>
                                            <tr>
                                                <td>ASN</td>
                                                <td><?PHP fancy_print($IPAddress->Connection->ASN); ?></td>
                                            </tr>
                                            <tr>
                                                <td>ISP</td>
                                                <td><?PHP fancy_print($IPAddress->Connection->ISP); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Current Time</td>
                                                <td><?PHP fancy_print($IPAddress->Timezone->CurrentName); ?></td>
                                            </tr>
                                            <tr>
                                                <td>GMT Offset</td>
                                                <td><?PHP fancy_print($IPAddress->Timezone->GMT_Offset); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?PHP HTML::importSection('footer'); ?>

            </div>

        </div>

        <?PHP HTML::importSection('js_scripts'); ?>
    </body>
</html>
