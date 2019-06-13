<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    $Configuration = \DynamicalWeb\DynamicalWeb::getConfiguration('configuration');

    $WebApplication = array(
        'location' => $Configuration['intellivoid_website']['location'],
        'resources' => $Configuration['intellivoid_website']['location'] . DIRECTORY_SEPARATOR . 'resources'
    );


    $it = new RecursiveDirectoryIterator($WebApplication['resources'] . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR);
    foreach(new RecursiveIteratorIterator($it) as $file)
    {
        if(pathinfo($file, PATHINFO_EXTENSION) == 'ini')
        {
            $WebApplication['configurations'][hash('sha256', $file)] =  $file;
        }

        if(pathinfo($file, PATHINFO_EXTENSION) == 'json')
        {
            $WebApplication['json_files'][hash('sha256', $file)] =  $file;
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'update_configuration')
            {
                if(isset($_GET['file']))
                {
                    if(isset($_POST['configuration']))
                    {
                        if(isset($WebApplication['configurations'][$_GET['file']]))
                        {
                            file_put_contents($WebApplication['configurations'][$_GET['file']], $_POST['configuration']);
                            header('Location: /intellivoid_website');
                            exit();
                        }
                    }
                }
            }

            if($_GET['action'] == 'update_json')
            {
                if(isset($_GET['file']))
                {
                    if(isset($_POST['json']))
                    {
                        if(isset($WebApplication['json_files'][$_GET['file']]))
                        {
                            file_put_contents($WebApplication['json_files'][$_GET['file']], $_POST['json']);
                            header('Location: /intellivoid_website');
                            exit();
                        }
                    }
                }
            }
        }
    }

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

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Configuration Files</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <!-- start accordion -->
                                    <div class="accordion" id="configuration_accord" role="tablist" aria-multiselectable="true">

                                        <?PHP
                                            foreach($WebApplication['configurations'] as $key => $value)
                                            {
                                                ?>
                                                <div class="panel">
                                                    <a class="panel-heading collapsed" role="tab" id="<?PHP HTML::print($key); ?>" data-toggle="collapse" data-parent="#configuration_accord" href="#<?PHP HTML::print($key . '_col'); ?>" aria-expanded="false" aria-controls="<?PHP HTML::print($key . '_col'); ?>">
                                                        <h4 class="panel-title"><?PHP HTML::print($value); ?></h4>
                                                    </a>
                                                    <div id="<?PHP HTML::print($key . '_col'); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?PHP HTML::print($key); ?>">
                                                        <div class="panel-body">

                                                            <form action="/openblu_web_application?action=update_configuration&file=<?PHP print(urlencode($key)); ?>" method="POST">
                                                                <div class="form-group">
                                                                    <label for="configuration">Edit Configuration</label>
                                                                    <textarea id="configuration" class="form-control" rows="10" name="configuration"><?PHP HTML::print(file_get_contents($value)); ?></textarea>
                                                                </div>

                                                                <input type="submit" value="Save Changes" class="btn btn-success">
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                                <?PHP
                                            }
                                        ?>

                                    </div>

                                    <!-- end of accordion -->

                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>JSON Files</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <!-- start accordion -->
                                    <div class="accordion" id="json_files_accord" role="tablist" aria-multiselectable="true">

                                        <?PHP
                                        foreach($WebApplication['json_files'] as $key => $value)
                                        {
                                            ?>
                                            <div class="panel">
                                                <a class="panel-heading collapsed" role="tab" id="<?PHP HTML::print($key); ?>" data-toggle="collapse" data-parent="#json_files_accord" href="#<?PHP HTML::print($key . '_col'); ?>" aria-expanded="false" aria-controls="<?PHP HTML::print($key . '_col'); ?>">
                                                    <h4 class="panel-title"><?PHP HTML::print($value); ?></h4>
                                                </a>
                                                <div id="<?PHP HTML::print($key . '_col'); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?PHP HTML::print($key); ?>">
                                                    <div class="panel-body">

                                                        <form action="/openblu_web_application?action=update_json&file=<?PHP print(urlencode($key)); ?>" method="POST">
                                                            <div class="form-group">
                                                                <label for="json">Edit JSON</label>
                                                                <textarea id="json" class="form-control" rows="10" name="json"><?PHP HTML::print(file_get_contents($value)); ?></textarea>
                                                            </div>

                                                            <input type="submit" value="Save Changes" class="btn btn-success">
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                            <?PHP
                                        }
                                        ?>

                                    </div>

                                    <!-- end of accordion -->

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
