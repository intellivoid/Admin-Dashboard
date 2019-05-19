<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;

    HTML::importScript('check_auth');
    HTML::importScript('check_existing_auth');
    HTML::importScript('verify_auth');

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('login_header'); ?>
        <title>Intellivoid Admin</title>
    </head>

    <body class="login">
        <div>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">

                        <form action="/login" method="POST">

                            <h1>Authentication</h1>
                            <div>
                                <label for="authentication_code">Authentication Code</label>
                                <input name="authentication_code" id="authentication_code" type="text" class="form-control" placeholder="Authentication Code" required="" />
                            </div>
                            <div>
                                <a class="btn btn-default submit" href="/">Authenticate</a>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">

                                <div>
                                    <h1>Intelli<b>void</b></h1>
                                    <p>&copy; Intellivoid 2017-<?PHP HTML::print(date('Y')); ?> All Rights Reserved.</p>
                                </div>
                            </div>

                        </form>

                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
