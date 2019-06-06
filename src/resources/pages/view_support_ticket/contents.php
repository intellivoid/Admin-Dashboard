<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    HTML::importScript('check_auth');
    HTML::importScript('require_auth');

    \DynamicalWeb\DynamicalWeb::loadLibrary('Support', 'Support', 'Support.php');
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
                </div>

                <?PHP HTML::importSection('footer'); ?>

            </div>

        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <h4>Text in a modal</h4>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>

                </div>
            </div>
        </div>

        <?PHP HTML::importSection('js_scripts'); ?>
    </body>
</html>
