<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');

    function totalSessionPages(\CoffeeHouse\CoffeeHouse $coffeeHouse): int
    {
        $SessionID = $coffeeHouse->getDatabase()->real_escape_string($_GET['session_id']);
        $Query = "SELECT id FROM `chat_dialogs` WHERE session_id='$SessionID'";
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
                return ceil($QueryResults->num_rows / 100);
            }
        }
    }

    function getSessionsPage(\CoffeeHouse\CoffeeHouse $coffeeHouse, int $page): array
    {
        $SessionID = $coffeeHouse->getDatabase()->real_escape_string($_GET['session_id']);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, session_id, step, input, output, timestamp FROM `chat_dialogs` WHERE session_id='$SessionID' ORDER BY step ASC  LIMIT 0, 100";
        }
        else
        {
            $CurrentPage = 0;
            $StartingItem = 0;

            while(true)
            {
                $CurrentPage += 1;
                $StartingItem += 100;
                if($CurrentPage == $page - 1)
                {
                    break;
                }
            }

            $Query = "SELECT id, session_id, step, input, output, timestamp FROM `chat_dialogs` WHERE session_id='$SessionID' ORDER BY step ASC LIMIT $StartingItem, 100";

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

        foreach(getSessionsPage($coffeeHouse, $Page) as $message)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            \DynamicalWeb\HTML::print($message['id']);
            print("</th>");

            print("<td>");
            \DynamicalWeb\HTML::print($message['step']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print(base64_decode($message['input']));
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print(base64_decode($message['output']));
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($message['timestamp']);
            print("</td>");

            print("</tr>");
        }

    }

    function printIndex(\CoffeeHouse\CoffeeHouse $coffeeHouse)
    {
        $TotalPages = totalSessionPages($coffeeHouse);
        $SessionID = urlencode($_GET['session_id']);

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
            print("<a href=\"/coffee_house_view_session?session_id=$SessionID&page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }