<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'update_plan')
            {
                HTML::importScript('update_plan');
            }

            if($_GET['action'] == 'start_plan')
            {
                HTML::importScript('start_plan');
            }
        }
    }
    else
    {
        if(isset($_GET['action']))
        {
            HTML::importScript('cancel_plan');
        }
    }

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $OpenBlu = new \OpenBlu\OpenBlu();

    $Plan = $OpenBlu->getPlanManager()->getPlan(\OpenBlu\Abstracts\SearchMethods\PlanSearchMethod::byId, $_GET['id']);

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
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Actions</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <div class="row">
                                        <h4>Cancel Plan</h4>
                                        <button type="button" onclick="location.href='/openblu_edit_plan?action=cancel_plan&id=<?PHP print(urlencode($_GET['id'])); ?>';" class="btn btn-danger">Cancel Plan</button>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <h4>Start Plan</h4>
                                        <form action="/openblu_edit_plan?action=start_plan&id=<?PHP print(urlencode($_GET['id'])); ?>" method="POST">

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

                                            <input type="submit" class="btn btn-success" value="Start Plan">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Details</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <form action="/openblu_edit_plan?action=update_plan&id=<?PHP print(urlencode($_GET['id'])); ?>" method="POST">

                                        <div class="form-group">
                                            <label for="id">ID</label>
                                            <input type="text" id="id" class="form-control" name="id" value="<?PHP HTML::print($Plan->Id); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="account_id">Account ID</label>
                                            <input type="text" id="account_id" class="form-control" name="account_id" value="<?PHP HTML::print($Plan->AccountId); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="access_key_id">Access Key ID</label>
                                            <input type="text" id="access_key_id" class="form-control" name="access_key_id" value="<?PHP HTML::print($Plan->AccessKeyId); ?>" readonly>
                                        </div>
                                        <button type="button" class="btn btn-block btn-success" onclick="location.href='/openblu_edit_access_key?id=<?PHP print(urlencode($Plan->AccessKeyId)); ?>'">View</button>

                                        <div class="form-group">
                                            <label for="active">Active</label>
                                            <select name="active" autocomplete="off" id="active" class="form-control">
                                                <option value="0"<?PHP if($Plan->Active == false){ print(' selected'); } ?>>False</option>
                                                <option value="1"<?PHP if($Plan->Active == true){ print(' selected'); } ?>>True</option>
                                            </select>
                                         </div>

                                        <div class="form-group">
                                            <label for="payment_required">Payment Required</label>
                                            <select name="payment_required" autocomplete="off" id="payment_required" class="form-control">
                                                <option value="0"<?PHP if($Plan->PaymentRequired == false){ print(' selected'); } ?>>False</option>
                                                <option value="1"<?PHP if($Plan->PaymentRequired == true){ print(' selected'); } ?>>True</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="promotion_code">Promotion Code</label>
                                            <input type="text" id="promotion_code" class="form-control" name="promotion_code" value="<?PHP HTML::print($Plan->PromotionCode); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="plan_started">Plan Started</label>
                                            <select name="plan_started" autocomplete="off" id="plan_started" class="form-control">
                                                <option value="0"<?PHP if($Plan->PlanStarted == false){ print(' selected'); } ?>>False</option>
                                                <option value="1"<?PHP if($Plan->PlanStarted == true){ print(' selected'); } ?>>True</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="plan_type">Plan Type</label>
                                            <select name="plan_type" autocomplete="off" id="plan_type" class="form-control">
                                                <option value="0"<?PHP if($Plan->PlanType == \OpenBlu\Abstracts\APIPlan::Free){ print(' selected'); } ?>>Free</option>
                                                <option value="1"<?PHP if($Plan->PlanType == \OpenBlu\Abstracts\APIPlan::Basic){ print(' selected'); } ?>>Basic</option>
                                                <option value="2"<?PHP if($Plan->PlanType == \OpenBlu\Abstracts\APIPlan::Enterprise){ print(' selected'); } ?>>Enterprise</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="price_per_cycle">Price Per Cycle</label>
                                            <input type="text" id="price_per_cycle" class="form-control" name="price_per_cycle" value="<?PHP HTML::print($Plan->PricePerCycle); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="monthly_calls">Monthly Calls</label>
                                            <input type="text" id="monthly_calls" class="form-control" name="monthly_calls" value="<?PHP HTML::print($Plan->MonthlyCalls); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="billing_cycle">Billing Cycle (Unix Timestamp)</label>
                                            <input type="text" id="billing_cycle" class="form-control" name="billing_cycle" value="<?PHP HTML::print($Plan->BillingCycle); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="next_billing_cycle">Next Billing Cycle (Unix Timestamp)</label>
                                            <input type="text" id="next_billing_cycle" class="form-control" name="next_billing_cycle" value="<?PHP HTML::print($Plan->NextBillingCycle); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="plan_created">Plan Created (Unix Timestamp)</label>
                                            <input type="text" id="plan_created" class="form-control" name="plan_created" value="<?PHP HTML::print($Plan->PlanCreated); ?>" readonly>
                                        </div>

                                        <input type="submit" class="btn btn-success" value="Save Changes">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?PHP HTML::importSection('footer'); ?>

            </div>

        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <h4>Text in a modal</h4>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>

                </div>
            </div>
        </div>

        <?PHP HTML::importSection('js_scripts'); ?>
    </body>
</html>
