<?php

use DynamicalWeb\HTML;

\DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $OpenBlu = new \OpenBlu\OpenBlu();


    function totalClientPages(\OpenBlu\OpenBlu $openBlu): int
    {
        $Query = "SELECT id FROM `clients`";
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

    function getClientPage(\OpenBlu\OpenBlu $openBlu, int $page): array
    {
        $TotalPages = totalClientPages($openBlu);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, public_id, account_id, os_name, os_version, auth_expires, client_name, client_version, client_uid, blocked, ip_address, last_connected_timestamp, registered_timestamp FROM `clients` ORDER BY `last_connected_timestamp` DESC LIMIT 0, 40";
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

            $Query = "SELECT id, public_id, os_name, os_version, account_id, auth_expires, client_name, client_version, client_uid, blocked, ip_address, last_connected_timestamp, registered_timestamp FROM `clients` ORDER BY `last_connected_timestamp` DESC LIMIT $StartingItem, 40";
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

        foreach(getClientPage($openBlu, $Page) as $client)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            switch($client['client_name'])
            {
                case 'win32_desktop':
                    print("<i class=\"fa fa-windows text-danger\"></i> ");
                    break;

                default:
                    print("<i class=\"fa fa-question text-danger\"></i> ");
                    break;
            }
            print("<a href=\"openblu_client?id=" . urlencode($client['id']) . "\">");
            \DynamicalWeb\HTML::print($client['id']);
            print("</a>");
            print("</th>");

            print("<td>");
            \DynamicalWeb\HTML::print($client['public_id']);
            print("</td>");

            print("<td>");
            if(strlen($client['client_uid']) > 15)
            {
                HTML::print(substr($client['client_uid'], 0, 15) . '...');
            }
            else
            {
                HTML::print($client['client_uid']);
            }
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($client['ip_address']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($client['os_name']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($client['os_version']);
            print("</td>");

            print("<td>");
            if($client['blocked'] == true)
            {
                HTML::print('True');
            }
            else
            {
                HTML::print('False');
            }
            print("</td>");

            print("</tr>");
        }

    }

    function printIndex(\OpenBlu\OpenBlu $openBlu)
    {
        $TotalPages = totalClientPages($openBlu);

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
            print("<a href=\"/openblu_clients?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }