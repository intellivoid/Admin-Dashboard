<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');
    HTML::importScript('list_messages');
    $CoffeeHouse = new \CoffeeHouse\CoffeeHouse();
    $Session = $CoffeeHouse->getForeignSessionsManager()->getSession(
            \CoffeeHouse\Abstracts\ForeignSessionSearchMethod::bySessionId, $_GET['session_id']
    );

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
                    <?PHP
                        if(isset($_GET['view_vars']))
                        {
                            if($_GET['view_vars'] == 'true')
                            {
                                ?>
                                <div class="row">

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Session Internal Details</h2>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="x_content">

                                                <div class="form-group">
                                                    <label for="headers">Headers</label>
                                                    <textarea id="headers" class="form-control" rows="8" name="headers" readonly><?PHP HTML::print(json_encode($Session->Headers, JSON_PRETTY_PRINT)); ?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="variables">Variables</label>
                                                    <textarea id="variables" class="form-control" rows="8" name="variables" readonly><?PHP HTML::print(json_encode($Session->Variables, JSON_PRETTY_PRINT)); ?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="cookies">Cookies</label>
                                                    <textarea id="cookies" class="form-control" rows="8" name="cookies" readonly><?PHP HTML::print(json_encode($Session->Cookies, JSON_PRETTY_PRINT)); ?></textarea>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                                <?PHP
                            }
                        }
                    ?>
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Session Details</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <div class="form-group">
                                        <label for="id">Internal ID</label>
                                        <input type="text" id="id" class="form-control" name="id" value="<?PHP HTML::print($Session->ID); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="session_id">Session ID</label>
                                        <input type="text" id="session_id" class="form-control" name="session_id" value="<?PHP HTML::print($Session->SessionID); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="language">Language</label>
                                        <input type="text" id="language" class="form-control" name="language" value="<?PHP HTML::print($Session->Language); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <?PHP
                                            $Available = "False";
                                            if($Session->Available == true)
                                            {
                                                $Available = "True";
                                            }
                                        ?>
                                        <label for="available">Available</label>
                                        <input type="text" id="available" class="form-control" name="available" value="<?PHP HTML::print($Available); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="expires">Expires</label>
                                        <input type="text" id="expires" class="form-control" name="expires" value="<?PHP HTML::print($Session->Expires); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="lsat_updated">Last Updated</label>
                                        <input type="text" id="lsat_updated" class="form-control" name="lsat_updated" value="<?PHP HTML::print($Session->LastUpdated); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="created">Created</label>
                                        <input type="text" id="created" class="form-control" name="created" value="<?PHP HTML::print($Session->Created); ?>" readonly>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                            <div class="x_title">
                                <h2>Session Messages</h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Step</th>
                                            <th>Input</th>
                                            <th>Output</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                </div>

                <?PHP HTML::importSection('footer'); ?>

            </div>

        </div>

        <?PHP HTML::importSection('js_scripts'); ?>
    </body>
</html>
