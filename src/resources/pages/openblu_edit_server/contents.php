<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['update']))
        {
            if($_GET['update'] == 'meta')
            {
                HTML::importScript('update_general_information');
            }

            if($_GET['update'] == 'security')
            {
                HTML::importScript('update_security');
            }

            if(isset($_GET['update']) == 'configuration')
            {
                HTML::importScript('update_configuration');
            }
        }
    }

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $OpenBlu = new \OpenBlu\OpenBlu();
    $Server = $OpenBlu->getVPNManager()->getVPN(
        \OpenBlu\Abstracts\SearchMethods\VPN::byID, (int)$_GET['id']
    );

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('header'); ?>
        <title>Intellivoid Admin - OpenBlu Edit Server</title>
    </head>

    <body class="nav-md">
        <div class="container body">

            <div class="main_container">

                <?PHP HTML::importSection('sideview'); ?>
                <?PHP HTML::importSection('navigation'); ?>

                <div class="right_col" role="main">

                    <div class="row">
                        <div class="page-title">
                            <div class="title_left">
                                <h3>OpenBlu Server - <?PHP HTML::print($Server->PublicID); ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>General Information</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <form method="POST" action="/openblu_edit_server?update=meta&id=<?PHP print(urlencode($_GET['id'])); ?>">

                                        <div class="form-group">
                                            <label for="id">ID</label>
                                            <input type="text" id="id" class="form-control" name="id" value="<?PHP HTML::print($Server->ID); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="public_d">Public ID</label>
                                            <input type="text" id="public_id" class="form-control" name="public_id" value="<?PHP HTML::print($Server->PublicID); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="ip_address">IP Address</label>
                                            <input type="text" id="ip_address" class="form-control" name="ip_address" value="<?PHP HTML::print($Server->IP); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="host_name">Host Name</label>
                                            <input type="text" id="host_name" class="form-control" name="host_name" value="<?PHP HTML::print($Server->HostName); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" id="country" class="form-control" name="country" value="<?PHP HTML::print($Server->Country); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="country_short">Country Short</label>
                                            <input type="text" id="country_short" class="form-control" name="country_short" value="<?PHP HTML::print($Server->CountryShort); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="sessions">Sessions</label>
                                            <input type="text" id="sessions" class="form-control" name="sessions" value="<?PHP HTML::print($Server->Sessions); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="total_sessions">Total Sessions</label>
                                            <input type="text" id="total_sessions" class="form-control" name="total_sessions" value="<?PHP HTML::print($Server->TotalSessions); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="ping">Ping (ms)</label>
                                            <input type="text" id="ping" class="form-control" name="ping" value="<?PHP HTML::print($Server->Ping); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="score">Score</label>
                                            <input type="text" id="score" class="form-control" name="score" value="<?PHP HTML::print($Server->Score); ?>">
                                        </div>

                                        <button type="submit" class="btn btn-success">Save Changes</button>

                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Security</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <form method="POST" action="/openblu_edit_server?update=security&id=<?PHP print(urlencode($_GET['id'])); ?>">

                                        <div class="form-group">
                                            <label for="certificate">Certificate</label>
                                            <textarea id="certificate" class="form-control" rows="8" name="certificate"><?PHP HTML::print($Server->Certificate); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="certificate_authority">Certificate Authority</label>
                                            <textarea id="certificate_authority" class="form-control" rows="8" name="certificate_authority"><?PHP HTML::print($Server->CertificateAuthority); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="key">Private RSA Key</label>
                                            <textarea id="key" class="form-control" rows="8" name="key"><?PHP HTML::print($Server->Key); ?></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success">Save Changes</button>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Configuration Paramerters</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <form method="POST" action="/openblu_edit_server?update=configuration&id=<?PHP print(urlencode($_GET['id'])); ?>">

                                        <div class="form-group">
                                            <textarea id="configuration" class="form-control" rows="12" name="configuration"><?PHP HTML::print(json_encode($Server->ConfigurationParameters, JSON_PRETTY_PRINT)); ?></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success">Save Changes</button>

                                    </form>
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
