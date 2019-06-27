<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');


    function totalAccessKeyPages(\CoffeeHouse\CoffeeHouse $coffeeHouse): int
    {
        $Query = "SELECT id FROM `access_keys`";
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
                return ceil($QueryResults->num_rows / 40);
            }
        }
    }

    function getAccessKeyPage(\CoffeeHouse\CoffeeHouse $coffeeHouse, int $page): array
    {
        $TotalPages = totalAccessKeyPages($coffeeHouse);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, public_id, state, creation_date FROM `access_keys` LIMIT 0, 40";
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

            $Query = "SELECT id, public_id, state, creation_date FROM `access_keys` LIMIT $StartingItem, 40";
        }

        $QueryResults = $coffeeHouse->getDatabase()->query($Query);
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

    function printTable(\CoffeeHouse\CoffeeHouse $coffeeHouse)
    {

        $Page = 1;

        if(isset($_GET['page']))
        {
            $Page = (int)$_GET['page'];
        }

        foreach(getAccessKeyPage($coffeeHouse, $Page) as $access_key)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/coffee_house_edit_access_key?id=" . urlencode($access_key['id']) . "\">");
            \DynamicalWeb\HTML::print($access_key['id']);
            print("</a>");
            print("</th>");

            print("<td>");
            \DynamicalWeb\HTML::print($access_key['public_id']);
            print("</td>");

            $State = 'Unknown';

            switch($access_key['state'])
            {
                case \ModularAPI\Abstracts\AccessKeyStatus::Activated:
                    $State = 'Activated';
                    break;

                case \ModularAPI\Abstracts\AccessKeyStatus::Suspended:
                    $State = 'Suspended';
                    break;

                case \ModularAPI\Abstracts\AccessKeyStatus::Limited:
                    $State = 'Limited';
                    break;

                default:
                    $State = 'Unknown';
                    break;
            }

            print("<td>");
            \DynamicalWeb\HTML::print($State);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($access_key['creation_date']);
            print("</td>");

            print("</tr>");
        }

    }

    function printIndex(\CoffeeHouse\CoffeeHouse $coffeeHouse)
    {
        $TotalPages = totalAccessKeyPages($coffeeHouse);

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
            print("<a href=\"/coffee_house_access_keys?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }