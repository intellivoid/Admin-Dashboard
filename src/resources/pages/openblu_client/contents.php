<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    if(isset($_GET['action']) == true)
    {
        if($_GET['action'] == 'block_client')
        {
            HTML::importScript('block_client');
        }

        if($_GET['action'] == 'unblock_client')
        {
            HTML::importScript('unblock_client');
        }
    }

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $OpenBlu = new \OpenBlu\OpenBlu();
    $Client = $OpenBlu->getClientManager()->getClient(\OpenBlu\Abstracts\SearchMethods\ClientSearchMethod::byId, $_GET['id']);
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
                                    <?PHP
                                        if($Client->Blocked == true)
                                        {
                                            print("<button class=\"btn btn-warning btn-block\" onclick=\"location.href='openblu_client?action=unblock_client&id=" . urlencode($_GET['id']) . "';\">Unblock Client</button>");
                                        }
                                        else
                                        {
                                            print("<button class=\"btn btn-danger btn-block\" onclick=\"location.href='openblu_client?action=block_client&id=" . urlencode($_GET['id']) . "';\">Block Client</button>");
                                        }
                                    ?>
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

                                    <div class="form-group">
                                        <label for="id">ID</label>
                                        <input type="text" id="id" class="form-control" name="id" value="<?PHP HTML::print($Client->ID); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="public_id">Public ID</label>
                                        <input type="text" id="public_id" class="form-control" name="public_id" value="<?PHP HTML::print($Client->PublicID); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="public_id">Public ID</label>
                                        <input type="text" id="public_id" class="form-control" name="public_id" value="<?PHP HTML::print($Client->PublicID); ?>" readonly>
                                    </div>

                                    <?PHP
                                        $AccountID = "None";
                                        $ViewButton = "";
                                        if($Client->AccountID !== 0)
                                        {
                                            $AccountID = $Client->AccountID;
                                            $ViewButton = "<br/><button class=\"btn btn-primary\" onclick=\"location.href='edit_account?id=" . $Client->AccountID . "'\">View Account</button>";
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label for="account_id">Account ID</label>
                                        <input type="text" id="account_id" class="form-control" name="account_id" value="<?PHP HTML::print($AccountID); ?>" readonly>
                                        <?PHP print($ViewButton); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="auth_expires">Auth Expires</label>
                                        <input type="text" id="auth_expires" class="form-control" name="auth_expires" value="<?PHP HTML::print($Client->AuthExpires); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="client_name">Client Name</label>
                                        <input type="text" id="client_name" class="form-control" name="client_name" value="<?PHP HTML::print($Client->ClientName); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="client_version">Client Version</label>
                                        <input type="text" id="client_version" class="form-control" name="client_version" value="<?PHP HTML::print($Client->ClientVersion); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="client_uid">Client Unique ID</label>
                                        <input type="text" id="client_uid" class="form-control" name="client_uid" value="<?PHP HTML::print($Client->ClientUid); ?>" readonly>
                                    </div>

                                    <?PHP
                                        $ClientBlocked = "False";
                                        if($Client->Blocked == true)
                                        {
                                            $ClientBlocked = "True";
                                        }
                                        else
                                        {
                                            $ClientBlocked = "False";
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label for="client_blocked">Blocked</label>
                                        <input type="text" id="client_blocked" class="form-control" name="client_blocked" value="<?PHP HTML::print($ClientBlocked); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="os_name">OS Name</label>
                                        <input type="text" id="os_name" class="form-control" name="os_name" value="<?PHP HTML::print($Client->osName); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="os_version">OS Version</label>
                                        <input type="text" id="os_version" class="form-control" name="os_version" value="<?PHP HTML::print($Client->osVersion); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="ip_address">IP Address</label>
                                        <input type="text" id="ip_address" class="form-control" name="ip_address" value="<?PHP HTML::print($Client->ipAddress); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="last_connected_timestamp">Last Connected Unix Timestamp</label>
                                        <input type="text" id="last_connected_timestamp" class="form-control" name="last_connected_timestamp" value="<?PHP HTML::print($Client->LastConnectedTimestamp); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="registered_timestamp">Registered Unix Timestamp</label>
                                        <input type="text" id="registered_timestamp" class="form-control" name="registered_timestamp" value="<?PHP HTML::print($Client->RegisteredTimestamp); ?>" readonly>
                                    </div>

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
