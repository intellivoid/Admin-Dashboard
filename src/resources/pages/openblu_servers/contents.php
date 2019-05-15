<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('header'); ?>
        <title>Intellivoid Admin - OpenBlu Servers</title>
    </head>

    <body class="nav-md">
        <div class="container body">

            <div class="main_container">

                <?PHP HTML::importSection('sideview'); ?>
                <?PHP HTML::importSection('navigation'); ?>
                <?PHP HTML::importScript('list_servers'); ?>

                <div class="right_col" role="main">
                    <div class="row">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2> OpenBlu VPN Servers
                                    <small>Servers hosted by OpenBlu</small>
                                </h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Public ID</th>
                                            <th>Host Name</th>
                                            <th>IP Address</th>
                                            <th>Score</th>
                                            <th>Ping</th>
                                            <th>Country</th>
                                            <th>Country Short</th>
                                            <th>Sessions</th>
                                            <th>Total Sessions</th>
                                            <th>Last Updated</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?PHP $OpenBlu = new \OpenBlu\OpenBlu(); ?>
                                        <?PHP printTable($OpenBlu); ?>
                                    </tbody>
                                </table>

                                <ul class="pagination">
                                    <?PHP printIndex($OpenBlu); ?>
                                </ul>
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
