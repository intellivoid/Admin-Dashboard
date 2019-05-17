<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $OpenBlu = new \OpenBlu\OpenBlu();


    function totalAccessKeyPages(\OpenBlu\OpenBlu $openBlu): int
    {
        $Query = "SELECT id FROM `access_keys`";
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

    function getAccessKeyPage(\OpenBlu\OpenBlu $openBlu, int $page): array
    {
        $TotalPages = totalAccessKeyPages($openBlu);

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

        foreach(getAccessKeyPage($openBlu, $Page) as $access_key)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/openblu_edit_access_key?id=" . urlencode($access_key['id']) . "\">");
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

    function printIndex(\OpenBlu\OpenBlu $openBlu)
    {
        $TotalPages = totalAccessKeyPages($openBlu);

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
            print("<a href=\"/openblu_access_keys?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }