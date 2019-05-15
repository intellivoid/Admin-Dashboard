<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $OpenBlu = new \OpenBlu\OpenBlu();


    function totalServerPages(\OpenBlu\OpenBlu $openBlu): int
    {
        $Query = "SELECT id FROM `vpns`";
        $QueryResults = $openBlu->database->query($Query);

        if($QueryResults == false)
        {
            die($openBlu->database->error);
        }
        else
        {
            if($QueryResults->num_rows == 0)
            {
                return 0;
            }
            else
            {
                return ceil($QueryResults->num_rows / 40);
            }
        }
    }

    function getServerPage(\OpenBlu\OpenBlu $openBlu, int $page): array
    {
        $TotalPages = totalServerPages($openBlu);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, public_id, host_name, ip_address, score, ping, country, country_short, sessions, total_sessions, last_updated, created FROM `vpns` ORDER BY `sessions` DESC LIMIT 0, 40";
        }
        else
        {
            $CurrentPage = 0;
            $StartingItem = 0;

            while(true)
            {
                $CurrentPage += 1;
                $StartingItem += 40;
                if($CurrentPage == $page - 1)
                {
                    break;
                }
            }

            $Query = "SELECT id, public_id, host_name, ip_address, score, ping, country, country_short, sessions, total_sessions, last_updated, created FROM `vpns` ORDER BY `sessions` DESC LIMIT $StartingItem, 40";
        }

        $QueryResults = $openBlu->database->query($Query);
        if($QueryResults == false)
        {
            die($this->openBlu->database->error);
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

    function printTable(\OpenBlu\OpenBlu $openBlu)
    {

        $Page = 1;

        if(isset($_GET['page']))
        {
            $Page = (int)$_GET['page'];
        }

        foreach(getServerPage($openBlu, $Page) as $server)
        {
            print("<tr onclick=\"location.href='openblu_edit_server?id=" . urlencode($server['id']) . "';\">");

            print("<th scope=\"row\">");
            \DynamicalWeb\HTML::print($server['id']);
            print("</th>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['public_id']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['host_name']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['ip_address']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['score']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['ping']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['country']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['country_short']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['sessions']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['total_sessions']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['last_updated']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($server['created']);
            print("</td>");

            print("</tr>");
        }

    }

    function printIndex(\OpenBlu\OpenBlu $openBlu)
    {
        $TotalPages = totalServerPages($openBlu);

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
            print("<a href=\"/openblu_servers?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }