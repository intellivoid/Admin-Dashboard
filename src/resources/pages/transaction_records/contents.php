<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\IntellivoidAccounts;

    HTML::importScript('check_auth');
    HTML::importScript('require_auth');
    HTML::importScript('list_transactions');
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
                                <h2>Filter</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form action="/support_tickets" method="GET">

                                    <div class="form-group">
                                        <label for="filter" class="control-label col-md-3 col-sm-3 col-xs-12">Filter Ticket Status</label>
                                        <div class="form-group">
                                            <label for="price_per_cycle">Price Per Cycle</label>
                                            <input type="text" id="price_per_cycle" class="form-control" name="price_per_cycle" value="0">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-danger">Filter</button>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2> Transaction Records </h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Public ID</th>
                                            <th>Account ID</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Vendor</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?PHP $IntellivoidAccounts = new IntellivoidAccounts(); ?>
                                        <?PHP printTable($IntellivoidAccounts); ?>
                                    </tbody>
                                </table>

                                <ul class="pagination">
                                    <?PHP printIndex($IntellivoidAccounts); ?>
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
