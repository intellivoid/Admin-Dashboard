<?php


    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'update_admin_notes')
        {
            if(isset($_POST['admin_notes']))
            {
                updateAdminNotes();
                header('Location: /view_support_ticket?id=' . urlencode($_GET['id']));
            }
        }
    }

    function updateAdminNotes()
    {
        if(strlen($_POST['admin_notes']) < 2)
        {
            return;
        }

        if(strlen($_POST['admin_notes']) > 2500)
        {
            return;
        }

        $Support = new \Support\Support();
        $SupportTicket = $Support->getTicketManager()->getSupportTicket(\Support\Abstracts\SupportTicketSearchMethod::byId, $_GET['id']);
        $SupportTicket->TicketNotes = $_POST['admin_notes'];
        $Support->getTicketManager()->updateSupportTicket($SupportTicket);

        return;
    }