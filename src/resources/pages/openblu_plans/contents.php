<?PHP

/** @noinspection PhpUnhandledExceptionInspection */
use DynamicalWeb\HTML;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'search')
        {
            HTML::importScript('search');
        }
    }
}

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
                <?PHP HTML::importScript('list_plans'); ?>

                <div class="right_col" role="main">

                    <div class="row">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2> OpenBlu Plans
                                    <small>Active user API Plans</small>
                                </h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table table-responsive table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Active</th>
                                        <th>Account ID</th>
                                        <th>Access Key ID</th>
                                        <th>Plan Type</th>
                                        <th>Promotion Code</th>
                                        <th>Monthly Calls</th>
                                        <th>Price Per Cycle</th>
                                        <th>Next Billing Cycle</th>
                                        <th>Billing Cycle</th>
                                        <th>Payment Required</th>
                                        <th>Plan Created</th>
                                        <th>Plan Started</th>
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
