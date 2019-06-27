<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');

    function totalSessionPages(\CoffeeHouse\CoffeeHouse $coffeeHouse): int
    {
        $Query = "SELECT id FROM `foreign_sessions`";
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
                return ceil($QueryResults->num_rows / 300);
            }
        }
    }

    function getSessionsPage(\CoffeeHouse\CoffeeHouse $coffeeHouse, int $page): array
    {
        $TotalPages = totalSessionPages($coffeeHouse);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, session_id, language, available, messages, expires, last_updated, created FROM `foreign_sessions` LIMIT 0, 300";
        }
        else
        {
            $CurrentPage = 0;
            $StartingItem = 0;

            while(true)
            {
                $CurrentPage += 1;
                $StartingItem += 300;
                if($CurrentPage == $page - 1)
                {
                    break;
                }
            }

            $Query = "SELECT id, session_id, language, available, messages, expires, last_updated, created FROM `foreign_sessions` LIMIT $StartingItem, 300";

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

        foreach(getSessionsPage($coffeeHouse, $Page) as $session)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/coffee_house_view_session?session_id=" . urlencode($session['session_id']) . "\">");
            \DynamicalWeb\HTML::print($session['id']);
            print("</a>");
            print("</th>");

            print("<td>");
            \DynamicalWeb\HTML::print(substr($session['session_id'], 0, 25) . '...');
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($session['language']);
            print("</td>");

            print("<td>");
            $available_bool = "False";
            if((bool)$session['available'] == true)
            {
                $available_bool = "True";
            }
            \DynamicalWeb\HTML::print($available_bool);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($session['messages']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($session['expires']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($session['last_updated']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($session['created']);
            print("</td>");

            print("</tr>");
        }

    }

    function printIndex(\CoffeeHouse\CoffeeHouse $coffeeHouse)
    {
        $TotalPages = totalSessionPages($coffeeHouse);

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
            print("<a href=\"/coffee_house_chat_sessions?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }