<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Support\Support;

    DynamicalWeb::loadLibrary('Support', 'Support', 'Support.php');

    function totalTicketsPages(Support $support): int
    {
        $Query = "SELECT id FROM `support_tickets`";
        if(isset($_GET['filter']))
        {
            $Filter = (int)$support->getDatabase()->real_escape_string($_GET['filter']);
            $Query = "SELECT id FROM `support_tickets` WHERE ticket_status=$Filter";
        }

        $QueryResults = $support->getDatabase()->query($Query);

        if($QueryResults == false)
        {
            die($support->getDatabase()->error);
        }
        else
        {
            if($QueryResults->num_rows == 0)
            {
                return 0;
            }
            else
            {
                return ceil($QueryResults->num_rows / 80);
            }
        }
    }

    function getTicketsPage(Support $support, int $page): array
    {
        $TotalPages = totalTicketsPages($support);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, ticket_number, source, subject, ticket_status, submission_timestamp  FROM `support_tickets` LIMIT 0, 80";

            if(isset($_GET['filter']))
            {
                $Filter = (int)$support->getDatabase()->real_escape_string($_GET['filter']);
                $Query = "SELECT id, ticket_number, source, subject, ticket_status, submission_timestamp FROM `support_tickets` WHERE ticket_status=$Filter LIMIT 0, 80";
            }
        }
        else
        {
            $CurrentPage = 0;
            $StartingItem = 0;

            while(true)
            {
                $CurrentPage += 1;
                $StartingItem += 80;
                if($CurrentPage == $page - 1)
                {
                    break;
                }
            }

            $Query = "SELECT id, ticket_number, source, subject, ticket_status, submission_timestamp  FROM `support_tickets` LIMIT $StartingItem, 80";

            if(isset($_GET['filter']))
            {
                $Filter = (int)$support->getDatabase()->real_escape_string($_GET['filter']);
                $Query = "SELECT id, ticket_number, source, subject, ticket_status, submission_timestamp  FROM `support_tickets` WHERE ticket_status=$Filter LIMIT $StartingItem, 80";
            }
        }

        $QueryResults = $support->getDatabase()->query($Query);
        if($QueryResults == false)
        {
            die($support->getDatabase()->error);
        }
        else
        {
            $ResultsArray = [];

            while($Row = $QueryResults->fetch_assoc())
            {
                $ResultsArray[] = $Row;
            }

            return $ResultsArray;
        }
    }

    function printTable(Support $support)
    {

        $Page = 1;

        if(isset($_GET['page']))
        {
            $Page = (int)$_GET['page'];
        }

        foreach(getTicketsPage($support, $Page) as $ticket)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/view_support_ticket?id=" . urlencode($ticket['id']) . "\">");
            HTML::print($ticket['id']);
            print("</a>");
            print("</th>");

            print("<td>");
            HTML::print($ticket['ticket_number']);
            print("</td>");

            print("<td>");
            HTML::print($ticket['source']);
            print("</td>");

            print("<td>");
            HTML::print(substr($ticket['subject'], 0, 15) . '...');
            print("</td>");

            print("<td>");
            HTML::print($ticket['ticket_status']);
            print("</td>");

            print("<td>");
            HTML::print($ticket['submission_timestamp']);
            print("</td>");

            print("</tr>");
        }

    }

    function printIndex(Support $support)
    {
        $TotalPages = totalTicketsPages($support);

        if($TotalPages == 0)
        {
            return;
        }

        $CurrentPage = 1;

        while(true)
        {
            if($CurrentPage > $TotalPages)
            {
                break;
            }

            print("<li class=\"paginate_button \">");
            print("<a href=\"/support_tickets?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }