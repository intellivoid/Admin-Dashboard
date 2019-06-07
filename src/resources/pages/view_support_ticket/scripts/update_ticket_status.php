<?php


    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'update')
        {
            if(isset($_GET['method']))
            {
                updateSupportTicket();
                header('Location: /view_support_ticket?id=' . urlencode($_GET['id']));
                exit();
            }
        }
    }

    function updateSupportTicket()
    {
        $Support = new \Support\Support();
        $SupportTicket = $Support->getTicketManager()->getSupportTicket(\Support\Abstracts\SupportTicketSearchMethod::byId, $_GET['id']);

        switch($_GET['method'])
        {
            case 'opened':
                $SupportTicket->TicketStatus = \Support\Abstracts\TicketStatus::Opened;
                break;

            case 'in_progress':
                $SupportTicket->TicketStatus = \Support\Abstracts\TicketStatus::InProgress;
                break;

            case 'unable_to_resolve':
                $SupportTicket->TicketStatus = \Support\Abstracts\TicketStatus::UnableToResolve;
                break;

            case 'resolved':
                $SupportTicket->TicketStatus = \Support\Abstracts\TicketStatus::Resolved;
                break;
        }

        $Support->getTicketManager()->updateSupportTicket($SupportTicket);
    }