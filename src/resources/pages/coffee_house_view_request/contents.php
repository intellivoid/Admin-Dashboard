<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');
    $CoffeeHouse = new \CoffeeHouse\CoffeeHouse();

    $ID = (int)$_GET['id'];

    $Query = "SELECT id, reference_id, execution_time, timestamp, client_ip, version, module, request_method, request_parameters, response_type, response_code, authentication_method, access_key_public_id, fatal_error, exception_details FROM `requests` WHERE id=$ID";

    $QueryResults = $CoffeeHouse->getDatabase()->query($Query);
    $Row = $QueryResults->fetch_array(MYSQLI_ASSOC);

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
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>View Request Details</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Request ID</td>
                                            <td><?PHP HTML::print($Row['id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Reference ID</td>
                                            <td><?PHP HTML::print($Row['reference_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Execution Time</td>
                                            <td><?PHP HTML::print($Row['execution_time'] . ' ms'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Unix Timestamp</td>
                                            <td><?PHP HTML::print($Row['timestamp']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Client IP</td>
                                            <td><a href="ip_lookup?ip=<?PHP print(urlencode($Row['client_ip'])); ?>"><?PHP HTML::print($Row['client_ip']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td>Version</td>
                                            <td><?PHP HTML::print($Row['version']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Module</td>
                                            <td><?PHP HTML::print($Row['module']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Request Method</td>
                                            <td><?PHP HTML::print($Row['request_method']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Request Parameters</td>
                                            <td><?PHP HTML::print($Row['request_parameters']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Response Type</td>
                                            <td><?PHP HTML::print($Row['response_type']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Authentication Method</td>
                                            <td><?PHP HTML::print($Row['authentication_method']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Access Key Public ID</td>
                                            <td>
                                                <a href="/openblu_access_keys?action=search&public_id=<?PHP print(urlencode($Row['access_key_public_id'])); ?>">
                                                    <?PHP HTML::print($Row['access_key_public_id']); ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fatal Error</td>
                                            <td><?PHP HTML::print($Row['fatal_error']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Exception Details</td>
                                            <td><?PHP HTML::print($Row['exception_details']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
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
