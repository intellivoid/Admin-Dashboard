<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

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
                                <h2>Search</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form action="/openblu_plans?action=search" method="POST">

                                    <div class="form-group">
                                        <label for="search_method" class="control-label col-md-3 col-sm-3 col-xs-12">Search Method</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <select name="search_method" autocomplete="off" id="search_method" class="form-control">
                                                <option value="id">ID</option>
                                                <option value="account_id">Account ID</option>
                                                <option value="access_key_id">Access Key ID</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <br/>

                                    <div class="form-group">
                                        <label for="search_value" class="control-label col-md-3 col-sm-3 col-xs-12">Value</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" name="search_value" id="search_value" class="form-control" placeholder="Search value">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-danger">Search</button>

                                </form>
                            </div>
                        </div>
                    </div>
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
