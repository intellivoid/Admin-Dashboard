<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'generate_signatures')
        {
            HTML::importScript('generate_signatures');
        }
    }

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $ModularAPI = new \ModularAPI\ModularAPI();
    $AccessKey = $ModularAPI->AccessKeys()->Manager->get(\ModularAPI\Abstracts\AccessKeySearchMethod::byID, $_GET['id']);

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
                                    <h2>General Information</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <form>

                                        <div class="form-group">
                                            <label for="id">ID</label>
                                            <input type="text" id="id" class="form-control" name="id" value="<?PHP HTML::print($AccessKey->ID); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="public_id">Public ID</label>
                                            <input type="text" id="public_id" class="form-control" name="public_id" value="<?PHP HTML::print($AccessKey->PublicID); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="public_key">Public Key</label>
                                            <input type="text" id="public_key" class="form-control" name="public_key" value="<?PHP HTML::print($AccessKey->PublicKey); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" autocomplete="off" id="status" class="form-control" readonly>
                                                <option value="0"<?PHP if($AccessKey->State == \ModularAPI\Abstracts\AccessKeyStatus::Activated){ print(' selected'); } ?>>Activated</option>
                                                <option value="1"<?PHP if($AccessKey->State == \ModularAPI\Abstracts\AccessKeyStatus::Suspended){ print(' selected'); } ?>>Suspended</option>
                                                <option value="2"<?PHP if($AccessKey->State == \ModularAPI\Abstracts\AccessKeyStatus::Limited){ print(' selected'); } ?>>Limited</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="creation_date">Creation Date</label>
                                            <input type="text" id="creation_date" class="form-control" name="creation_date" value="<?PHP HTML::print($AccessKey->CreationDate); ?>" readonly>
                                        </div>

                                        <button type="button" class="btn btn-block btn-info" onclick="location.href='/openblu_requests?filter=<?PHP print(urlencode($AccessKey->PublicID)); ?>';">View Request History</button>

                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Signatures</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <div class="form-group">
                                        <label for="time_signature">Time Signature</label>
                                        <input type="text" id="time_signature" class="form-control" name="time_signature" value="<?PHP HTML::print($AccessKey->Signatures->TimeSignature); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="public_signature">Public Signature</label>
                                        <input type="text" id="public_signature" class="form-control" name="public_signature" value="<?PHP HTML::print($AccessKey->Signatures->PublicSignature); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="private_signature">Private Signature</label>
                                        <input type="text" id="private_signature" class="form-control" name="private_signature" value="<?PHP HTML::print($AccessKey->Signatures->PrivateSignature); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="issuer_name">Issuer Name</label>
                                        <input type="text" id="issuer_name" class="form-control" name="issuer_name" value="<?PHP HTML::print($AccessKey->Signatures->IssuerName); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="certificate">Certificate</label>
                                        <textarea id="certificate" class="form-control" rows="8" name="certificate" readonly><?PHP HTML::print($AccessKey->Signatures->createCertificate()); ?></textarea>
                                    </div>

                                    <button type="button" onclick="location.href='/openblu_edit_access_key?action=generate_signatures&id=<?PHP print(urlencode($_GET['id'])); ?>';" class="btn btn-success">Generate New Signatures</button>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Usage Analytics</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="api-usage-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?PHP HTML::importSection('footer'); ?>

            </div>

        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <?PHP HTML::importScript('generate_chart_js'); ?>
        <?PHP generateJs($AccessKey); ?>
    </body>
</html>
