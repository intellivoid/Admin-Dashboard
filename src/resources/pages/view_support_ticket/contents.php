<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    \DynamicalWeb\DynamicalWeb::loadLibrary('Support', 'Support', 'Support.php');
    HTML::importScript('update_ticket_status');
    HTML::importScript('update_ticket_notes');
    $Support = new \Support\Support();

    $SupportTicket = $Support->getTicketManager()->getSupportTicket(\Support\Abstracts\SupportTicketSearchMethod::byId, $_GET['id']);

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
                                    <button class="btn btn-block btn-info" onclick="location.href='/view_support_ticket?action=update&method=opened&id=<?PHP print(urlencode($_GET['id'])); ?>'">
                                        Set as Opened <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-block btn-warning" onclick="location.href='/view_support_ticket?action=update&method=in_progress&id=<?PHP print(urlencode($_GET['id'])); ?>'">
                                        Set as In Progress <i class="fa fa-chevron-right"></i>
                                    </button>
                                    <button class="btn btn-block btn-danger" onclick="location.href='/view_support_ticket?action=update&method=unable_to_resolve&id=<?PHP print(urlencode($_GET['id'])); ?>'">
                                        Set as Unable to Resolve <i class="fa fa-close"></i>
                                    </button>
                                    <button class="btn btn-block btn-success" onclick="location.href='/view_support_ticket?action=update&method=resolved&id=<?PHP print(urlencode($_GET['id'])); ?>'">
                                        Set as Resolved <i class="fa fa-check"></i>
                                    </button>
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
                                        <label for="id">Internal ID</label>
                                        <input type="text" id="id" class="form-control" name="id" value="<?PHP HTML::print($SupportTicket->ID); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="ticket_number">Ticket Number</label>
                                        <input type="text" id="ticket_number" class="form-control" name="ticket_number" value="<?PHP HTML::print($SupportTicket->TicketNumber); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="response_email">Response Email</label>
                                        <br/>
                                        <a href="mailto:<?PHP HTML::print($SupportTicket->ResponseEmail); ?>">Send Email</a>
                                        <input type="text" id="response_email" class="form-control" name="response_email" value="<?PHP HTML::print($SupportTicket->ResponseEmail); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="source">Source</label>
                                        <input type="text" id="source" class="form-control" name="source" value="<?PHP HTML::print($SupportTicket->Source); ?>" readonly>
                                    </div>

                                    <?PHP
                                        $Status = 'Unknown';

                                        switch($SupportTicket->TicketStatus)
                                        {
                                            case \Support\Abstracts\TicketStatus::Opened:
                                                $Status = 'Opened';
                                                break;

                                            case \Support\Abstracts\TicketStatus::InProgress:
                                                $Status = 'In Progress';
                                                break;

                                            case \Support\Abstracts\TicketStatus::UnableToResolve:
                                                $Status = 'Unable to Resolve';
                                                break;

                                            case \Support\Abstracts\TicketStatus::Resolved:
                                                $Status = 'Resolved';
                                                break;
                                        }
                                    ?>

                                    <div class="form-group">
                                        <label for="ticket_status">Ticket Status</label>
                                        <input type="text" id="ticket_status" class="form-control" name="ticket_status" value="<?PHP HTML::print($Status); ?>" readonly>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Ticket Information</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <form action="/view_support_ticket?action=update_admin_notes&id=<?PHP print(urlencode($_GET['id'])); ?>" method="POST">
                                        <div class="form-group">
                                            <label for="subject">Subject</label>
                                            <input type="text" id="subject" class="form-control" name="subject" value="<?PHP HTML::print($SupportTicket->Subject); ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_message">User Message</label>
                                            <textarea id="user_message" class="form-control" rows="10" name="json" readonly><?PHP HTML::print($SupportTicket->Message); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="admin_notes">Administrator Notes</label>
                                            <textarea id="admin_notes" class="form-control" rows="10" name="admin_notes"><?PHP HTML::print($SupportTicket->TicketNotes); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Save Administrator Notes">
                                        </div>
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
