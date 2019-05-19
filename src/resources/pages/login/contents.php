<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;

    HTML::importScript('verify_auth');
    HTML::importScript('check_existing_auth');

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
                        <form>
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

                <div id="register" class="animate form registration_form">
                    <section class="login_content">
                        <form>
                            <h1>Create Account</h1>
                            <div>
                                <input type="text" class="form-control" placeholder="Username" required="" />
                            </div>
                            <div>
                                <input type="email" class="form-control" placeholder="Email" required="" />
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password" required="" />
                            </div>
                            <div>
                                <a class="btn btn-default submit" href="index.html">Submit</a>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">Already a member ?
                                    <a href="#signin" class="to_register"> Log in </a>
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                    <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
