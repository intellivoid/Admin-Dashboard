<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    $Configuration = \DynamicalWeb\DynamicalWeb::getConfiguration('configuration');

    $WebApplication = array(
        'location' => $Configuration['openblu_web_application']['location'],
        'resources' => $Configuration['openblu_web_application']['location'] . DIRECTORY_SEPARATOR . 'resources'
    );

    $WebApplication['openblu'] = $WebApplication['resources'] . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'OpenBlu';
    $WebApplication['intellivoid_accounts'] = $WebApplication['resources'] . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'IntellivoidAccounts';
    $WebApplication['logixal'] = $WebApplication['resources'] . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'Logixal';
    $WebApplication['modular_api'] = $WebApplication['resources'] . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'ModularAPI';
    $WebApplication['sws'] = $WebApplication['resources'] . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'sws';

    $OpenBluVersion = json_decode(file_get_contents($WebApplication['openblu'] . DIRECTORY_SEPARATOR . 'openblu.json'));
    $IntellivoidAccountsVersion = json_decode(file_get_contents($WebApplication['intellivoid_accounts'] . DIRECTORY_SEPARATOR . 'intellivoid_accounts.json'));
    $LogixalVersion = json_decode(file_get_contents($WebApplication['logixal'] . DIRECTORY_SEPARATOR . 'logixal.json'));
    $ModularAPIVersion = json_decode(file_get_contents($WebApplication['modular_api'] . DIRECTORY_SEPARATOR . 'modular-api.json'));
    $swsVersion = json_decode(file_get_contents($WebApplication['sws'] . DIRECTORY_SEPARATOR . 'sws.json'));

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
                                <h2>Installed Libraries</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Library</th>
                                            <th>Version</th>
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>OpenBlu</td>
                                            <td><?PHP HTML::print($OpenBluVersion->version); ?></td>
                                            <td><?PHP HTML::print($WebApplication['openblu']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Intellivoid Accounts</td>
                                            <td><?PHP HTML::print($IntellivoidAccountsVersion->version); ?></td>
                                            <td><?PHP HTML::print($WebApplication['intellivoid_accounts']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Logixal</td>
                                            <td><?PHP HTML::print($LogixalVersion->version); ?></td>
                                            <td><?PHP HTML::print($WebApplication['logixal']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>ModularAPI</td>
                                            <td><?PHP HTML::print($ModularAPIVersion->VERSION); ?></td>
                                            <td><?PHP HTML::print($WebApplication['modular_api']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>sws</td>
                                            <td><?PHP HTML::print($swsVersion->version); ?></td>
                                            <td><?PHP HTML::print($WebApplication['sws']); ?></td>
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
