<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use IntellivoidAccounts\Abstracts\OperatorType;
use IntellivoidAccounts\Abstracts\SearchMethods\TransactionRecordSearchMethod;
use IntellivoidAccounts\Abstracts\TransactionType;
use IntellivoidAccounts\IntellivoidAccounts;

    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
    $IntellivoidAccounts = new IntellivoidAccounts();
    $TransactionRecord = $IntellivoidAccounts->getTransactionRecordManager()->getTransactionRecord(TransactionRecordSearchMethod::byId, $_GET['id']);

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
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>View Transaction Details</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Transaction Internal ID</td>
                                            <td><?PHP HTML::print($TransactionRecord->ID); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Public ID</td>
                                            <td><?PHP print(wordwrap($TransactionRecord->PublicID, 50, "<br/>\r\n", true)); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Account ID</td>
                                            <td><?PHP HTML::print($TransactionRecord->AccountID); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Vendor</td>
                                            <td><?PHP HTML::print($TransactionRecord->Vendor); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <?PHP
                                                $Type = 'Unknown';
                                                switch($TransactionRecord->Type)
                                                {
                                                    case TransactionType::Payment:
                                                        $Type = 'Payment';
                                                        break;

                                                    case TransactionType::SubscriptionPayment:
                                                        $Type = 'Subscription Payment';
                                                        break;

                                                    case TransactionType::Deposit:
                                                        $Type = 'Deposit';
                                                        break;

                                                    case TransactionType::Withdraw:
                                                        $Type = 'Withdraw';
                                                        break;

                                                    case TransactionType::Refund:
                                                        $Type = 'Refund';
                                                        break;
                                                }
                                            ?>
                                            <td><?PHP HTML::print($Type); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Amount</td>
                                            <?PHP
                                                switch($TransactionRecord->OperatorType)
                                                {
                                                    case OperatorType::Deposit:
                                                        print("<td class=\"text-success\">$" . $TransactionRecord->Amount . "</td>");
                                                        break;

                                                    case OperatorType::Withdraw:
                                                        print("<td class=\"text-danger\">-$" . $TransactionRecord->Amount . "</td>");
                                                        break;

                                                    case OperatorType::None:
                                                        print("<td\">$" . $TransactionRecord->Amount . "</td>");
                                                        break;
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Unix Timestamp</td>
                                            <td><?PHP HTML::print($TransactionRecord->Timestamp); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
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
