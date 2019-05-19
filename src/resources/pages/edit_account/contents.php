<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'update_information')
            {
                HTML::importScript('update_information');
            }

            if($_GET['action'] == 'update_personal_information')
            {
                HTML::importScript('personal_information');
            }

            if($_GET['action'] == 'add_balance')
            {
                HTML::importScript('add_balance');
            }

            if($_GET['action'] == 'remove_balance')
            {
                HTML::importScript('remove_balance');
            }
        }
    }
    else
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'reset_balance')
            {
                HTML::importScript('reset_balance');
            }
        }
    }

    \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
    $IntellivoidAccounts = new \IntellivoidAccounts\IntellivoidAccounts();

    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(\IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byId, $_GET['id']);

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
                                    <form action="/edit_account?action=update_information&id=<?PHP print(urlencode($_GET['id'])); ?>" method="POST">

                                        <div class="form-group">
                                            <label for="id">ID</label>
                                            <input type="text" id="id" class="form-control" name="id" value="<?PHP HTML::print($Account->ID); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="public_id">Public ID</label>
                                            <input type="text" id="public_id" class="form-control" name="public_id" value="<?PHP HTML::print($Account->PublicID); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" id="username" class="form-control" name="username" value="<?PHP HTML::print($Account->Username); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Password (Hashed)</label>
                                            <input type="text" id="password" class="form-control" name="password" value="<?PHP HTML::print($Account->Password); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" id="email" class="form-control" name="email" value="<?PHP HTML::print($Account->Email); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" autocomplete="off" id="status" class="form-control">
                                                <option value="0"<?PHP if($Account->Status == \IntellivoidAccounts\Abstracts\AccountStatus::Active){ print(' selected'); } ?>>Active</option>
                                                <option value="1"<?PHP if($Account->Status == \IntellivoidAccounts\Abstracts\AccountStatus::Suspended){ print(' selected'); } ?>>Suspended</option>
                                                <option value="2"<?PHP if($Account->Status == \IntellivoidAccounts\Abstracts\AccountStatus::Limited){ print(' selected'); } ?>>Limited</option>
                                                <option value="3"<?PHP if($Account->Status == \IntellivoidAccounts\Abstracts\AccountStatus::VerificationRequired){ print(' selected'); } ?>>Verification Required</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="last_login_id">Last Login ID</label>
                                            <input type="text" id="last_login_id" class="form-control" name="last_login_id" value="<?PHP HTML::print($Account->LastLoginID); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="creation_date">Creation Date</label>
                                            <input type="text" id="creation_date" class="form-control" name="creation_date" value="<?PHP HTML::print($Account->CreationDate); ?>" readonly>
                                        </div>

                                        <button type="submit" class="btn btn-block btn-success">Save Changes</button>

                                    </form>
                                    <button type="button" onclick="location.href='/login_records&filter=<?PHP print(urlencode($_GET['id'])); ?>'" class="btn btn-block btn-info">View Login History</button>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Personal Information</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <form method="POST" action="/edit_account?id=<?PHP print(urlencode($_GET['id'])) ?>&action=update_personal_information">

                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" id="first_name" class="form-control" name="first_name" value="<?PHP HTML::print((string)$Account->PersonalInformation->FirstName); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" id="last_name" class="form-control" name="last_name" value="<?PHP HTML::print((string)$Account->PersonalInformation->LastName); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" id="country" class="form-control" name="country" value="<?PHP HTML::print((string)$Account->PersonalInformation->Country); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" id="phone_number" class="form-control" name="phone_number" value="<?PHP HTML::print((string)$Account->PersonalInformation->PhoneNumber); ?>">
                                        </div>

                                        <h4>Birth Date</h4>
                                        <div class="form-group">
                                            <label for="bod_day">Day</label>
                                            <input type="text" id="bod_day" class="form-control" name="bod_day" value="<?PHP HTML::print((string)$Account->PersonalInformation->BirthDate->Day); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="bod_month">Month</label>
                                            <input type="text" id="bod_month" class="form-control" name="bod_month" value="<?PHP HTML::print((string)$Account->PersonalInformation->BirthDate->Month); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="bod_year">Year</label>
                                            <input type="text" id="bod_year" class="form-control" name="bod_year" value="<?PHP HTML::print((string)$Account->PersonalInformation->BirthDate->Year); ?>">
                                        </div>

                                        <button type="submit" class="btn btn-block btn-success">Save Changes</button>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Account Balance</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <h4>Current Balance: $<?PHP HTML::print((string)$Account->Configuration->Balance); ?> U.S.</h4>

                                    <hr/>
                                    <form action="/edit_account?action=add_balance&id=<?PHP print(urlencode($_GET['id'])); ?>" method="POST">
                                        <div class="form-group">
                                            <label for="balance">Add to Balance</label>
                                            <input type="text" id="balance" class="form-control" name="balance" value="0">
                                        </div>
                                        <button type="submit" class="btn btn-success">Add to balance</button>
                                    </form>

                                    <hr/>
                                    <form action="/edit_account?action=remove_balance&id=<?PHP print(urlencode($_GET['id'])); ?>" method="POST">
                                        <div class="form-group">
                                            <label for="balance">Remove from Balance</label>
                                            <input type="text" id="balance" class="form-control" name="balance" value="0">
                                        </div>
                                        <button type="submit" class="btn btn-danger">Remove from balance</button>
                                    </form>

                                    <hr/>
                                    <button type="button" onclick="location.href='/edit_account?action=reset_balance&id=<?PHP print(urlencode($_GET['id'])); ?>'" class="btn btn-danger">Reset Balance</button>

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
