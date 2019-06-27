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

            if($_GET['action'] == 'create_plan')
            {
                HTML::importScript('create_plan');
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
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target=".create-plan-modal">Create New Plan</button>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade create-plan-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <form action="/openblu_plans?action=create_plan" method="POST">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="create_plan_title">Create Plan</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="account_id">Account ID</label>
                                            <input type="text" id="account_id" class="form-control" name="account_id" value="1">
                                        </div>

                                        <div class="form-group">
                                            <label for="plan_type">Plan Type</label>
                                            <select name="plan_type" autocomplete="off" id="plan_type" class="form-control">
                                                <option value="0">Free</option>
                                                <option value="1">Basic</option>
                                                <option value="2">Enterprise</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="monthly_calls">Monthly Calls</label>
                                            <input type="text" id="monthly_calls" class="form-control" name="monthly_calls" value="1000">
                                        </div>

                                        <div class="form-group">
                                            <label for="billing_cycle">Billing Cycle (Unix Timestamp)</label>
                                            <input type="text" id="billing_cycle" class="form-control" name="billing_cycle" value="86400">
                                        </div>

                                        <div class="form-group">
                                            <label for="price_per_cycle">Price Per Cycle</label>
                                            <input type="text" id="price_per_cycle" class="form-control" name="price_per_cycle" value="0">
                                        </div>

                                        <div class="form-group">
                                            <label for="promotion_code">Promotion Code</label>
                                            <input type="text" id="promotion_code" class="form-control" name="promotion_code" value="NORMAL">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <input type="submit" value="Create Plan" class="btn btn-primary">
                                    </div>
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
