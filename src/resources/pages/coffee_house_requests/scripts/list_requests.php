<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');

    function totalRequestPages(\CoffeeHouse\CoffeeHouse $coffeeHouse): int
    {
        $Query = "SELECT id FROM `requests`";
        if(isset($_GET['filter']))
        {
            $Filter = $coffeeHouse->getDatabase()->real_escape_string($_GET['filter']);
            $Query = "SELECT id FROM `requests` WHERE access_key_public_id='$Filter'";
        }
        $QueryResults = $coffeeHouse->getDatabase()->query($Query);

        if($QueryResults == false)
        {
            die($coffeeHouse->getDatabase()->error);
        }
        else
        {
            if($QueryResults->num_rows == 0)
            {
                return 0;
            }
            else
            {
                return ceil($QueryResults->num_rows / 1000);
            }
        }
    }

    function getRequestsPage(\CoffeeHouse\CoffeeHouse $coffeeHouse, int $page): array
    {
        $TotalPages = totalRequestPages($coffeeHouse);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, reference_id, access_key_public_id, execution_time, client_ip, version, module, request_method, response_type, response_code, authentication_method FROM `requests` LIMIT 0, 1000";

            if(isset($_GET['filter']))
            {
                $Filter = $coffeeHouse->getDatabase()->real_escape_string($_GET['filter']);
                $Query = "SELECT id, reference_id, access_key_public_id, execution_time, client_ip, version, module, request_method, response_type, response_code, authentication_method FROM `requests` WHERE access_key_public_id='$Filter' LIMIT 0, 1000";
            }
        }
        else
        {
            $CurrentPage = 0;
            $StartingItem = 0;

            while(true)
            {
                $CurrentPage += 1;
                $StartingItem += 1000;
                if($CurrentPage == $page - 1)
                {
                    break;
                }
            }

            $Query = "SELECT id, reference_id, access_key_public_id, execution_time, client_ip, version, module, request_method, response_type, response_code, authentication_method FROM `requests` LIMIT $StartingItem, 1000";

            if(isset($_GET['filter']))
            {
                $Filter = $coffeeHouse->getDatabase()->real_escape_string($_GET['filter']);
                $Query = "SELECT id, reference_id, access_key_public_id, execution_time, client_ip, version, module, request_method, response_type, response_code, authentication_method FROM `requests` WHERE access_key_public_id='$Filter' LIMIT $StartingItem, 1000";
            }
        }

        $QueryResults = $coffeeHouse->getDatabase()->query($Query);
        if($QueryResults == false)
        {
            die($coffeeHouse->getDatabase()->error);
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

    function printTable(\CoffeeHouse\CoffeeHouse $coffeeHouse)
    {

        $Page = 1;

        if(isset($_GET['page']))
        {
            $Page = (int)$_GET['page'];
        }

        foreach(getRequestsPage($coffeeHouse, $Page) as $request)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/coffee_house_view_request?id=" . urlencode($request['id']) . "\">");
            \DynamicalWeb\HTML::print($request['id']);
            print("</a>");
            print("</th>");

            print("<td>");
            \DynamicalWeb\HTML::print(substr($request['reference_id'], 0, 15) . '...');
            print("</td>");

            print("<td>");
            print("<a href=\"/coffee_house_access_keys?action=search&public_id=" . urlencode($request['access_key_public_id']) . "\">");
            \DynamicalWeb\HTML::print(substr($request['access_key_public_id'], 0, 15) . '...');
            print("</a>");
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($request['execution_time'] . 'ms');
            print("</td>");

            print("<td>");
            print("<a href=\"ip_lookup?ip=" . urlencode($request['client_ip']) . "\">");
            $IP = $request['client_ip'];
            if(strlen($IP) > 15)
            {
                $IP = substr($IP, 0, 15) . '...';
            }
            \DynamicalWeb\HTML::print($IP);
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

    function printIndex(\CoffeeHouse\CoffeeHouse $coffeeHouse)
    {
        $TotalPages = totalRequestPages($coffeeHouse);

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
            print("<a href=\"/coffee_house_requests?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }