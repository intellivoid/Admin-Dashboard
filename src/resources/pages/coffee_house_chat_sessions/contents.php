<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');
    HTML::importScript('list_sessions');

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
                                <h2> CoffeeHouse Chat Sessions</h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Session ID</th>
                                            <th>Language</th>
                                            <th>Available</th>
                                            <th>Messages</th>
                                            <th>Expires</th>
                                            <th>Last Updated</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?PHP $CoffeeHouse = new \CoffeeHouse\CoffeeHouse(); ?>
                                    <?PHP printTable($CoffeeHouse); ?>
                                    </tbody>
                                </table>

                                <ul class="pagination">
                                    <?PHP printIndex($CoffeeHouse); ?>
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
