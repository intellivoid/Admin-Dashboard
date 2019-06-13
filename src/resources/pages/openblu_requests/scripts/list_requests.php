<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $OpenBlu = new \OpenBlu\OpenBlu();


    function totalRequestPages(\OpenBlu\OpenBlu $openBlu): int
    {
        $Query = "SELECT id FROM `requests`";
        if(isset($_GET['filter']))
        {
            $Filter = $openBlu->database->real_escape_string($_GET['filter']);
            $Query = "SELECT id FROM `requests` WHERE access_key_public_id='$Filter'";
        }
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
                return ceil($QueryResults->num_rows / 80);
            }
        }
    }

    function getRequestsPage(\OpenBlu\OpenBlu $openBlu, int $page): array
    {
        $TotalPages = totalRequestPages($openBlu);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, reference_id, access_key_public_id, execution_time, client_ip, version, module, request_method, response_type, response_code, authentication_method FROM `requests` LIMIT 0, 80";

            if(isset($_GET['filter']))
            {
                $Filter = $openBlu->database->real_escape_string($_GET['filter']);
                $Query = "SELECT id, reference_id, access_key_public_id, execution_time, client_ip, version, module, request_method, response_type, response_code, authentication_method FROM `requests` WHERE access_key_public_id='$Filter' LIMIT 0, 80";
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

            $Query = "SELECT id, reference_id, access_key_public_id, execution_time, client_ip, version, module, request_method, response_type, response_code, authentication_method FROM `requests` LIMIT $StartingItem, 80";

            if(isset($_GET['filter']))
            {
                $Filter = $openBlu->database->real_escape_string($_GET['filter']);
                $Query = "SELECT id, reference_id, access_key_public_id, execution_time, client_ip, version, module, request_method, response_type, response_code, authentication_method FROM `requests` WHERE access_key_public_id='$Filter' LIMIT $StartingItem, 80";
            }
        }

        $QueryResults = $openBlu->database->query($Query);
        if($QueryResults == false)
        {
            die($openBlu->database->error);
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

        foreach(getRequestsPage($openBlu, $Page) as $request)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/openblu_view_request?id=" . urlencode($request['id']) . "\">");
            \DynamicalWeb\HTML::print($request['id']);
            print("</a>");
            print("</th>");

            print("<td>");
            \DynamicalWeb\HTML::print(substr($request['reference_id'], 0, 15) . '...');
            print("</td>");

            print("<td>");
            print("<a href=\"/openblu_access_keys?action=search&public_id=" . urlencode($request['access_key_public_id']) . "\">");
            \DynamicalWeb\HTML::print(substr($request['access_key_public_id'], 0, 15) . '...');
            print("</a>");
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($request['execution_time'] . 'ms');
            print("</td>");

            print("<td>");
            print("<a href=\"ip_lookup?ip=" . urlencode($request['client_ip']) . "\">");
            \DynamicalWeb\HTML::print($request['client_ip']);
            print("</a>");
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($request['version']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($request['module']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($request['request_method']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($request['response_type']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($request['response_code']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($request['authentication_method']);
            print("</td>");


            print("</tr>");
        }

    }

    function printIndex(\OpenBlu\OpenBlu $openBlu)
    {
        $TotalPages = totalRequestPages($openBlu);

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
            print("<a href=\"/openblu_requests?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }