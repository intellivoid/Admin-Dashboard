<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    HTML::importScript('list_tickets');

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
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <select name="filter" autocomplete="off" id="filter" class="form-control">
                                                <option value="0">Opened</option>
                                                <option value="1">In Progress</option>
                                                <option value="2">Unable to Resolve</option>
                                                <option value="3">Resolved</option>
                                            </select>
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
                                <h2> OpenBlu VPN Servers
                                    <small>Servers hosted by OpenBlu</small>
                                </h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table table-responsive table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ticker Number</th>
                                        <th>Source</th>
                                        <th>Subject</th>
                                        <th>Ticket Status</th>
                                        <th>Submission Timestamp</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?PHP $Support = new \Support\Support(); ?>
                                    <?PHP printTable($Support); ?>
                                    </tbody>
                                </table>

                                <ul class="pagination">
                                    <?PHP printIndex($Support); ?>
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
