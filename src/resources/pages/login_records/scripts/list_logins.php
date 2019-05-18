<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');


    function totalLoginPages(\IntellivoidAccounts\IntellivoidAccounts $intellivoidAccounts): int
    {
        $Query = "SELECT id FROM `login_records`";
        $QueryResults = $intellivoidAccounts->database->query($Query);

        if($QueryResults == false)
        {
            die($intellivoidAccounts->database->error);
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

    function getLoginsPage(\IntellivoidAccounts\IntellivoidAccounts $intellivoidAccounts, int $page): array
    {
        $TotalPages = totalLoginPages($intellivoidAccounts);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, public_id, account_id, ip_address, origin, time, status FROM `login_records` ORDER BY `time` DESC LIMIT 0, 100";
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

            $Query = "SELECT id, public_id, account_id, ip_address, origin, time, status FROM `login_records` ORDER BY `time` DESC LIMIT $StartingItem, 100";
        }

        $QueryResults = $intellivoidAccounts->database->query($Query);
        $ResultsArray = [];

        while($Row = $QueryResults->fetch_assoc())
        {
            $ResultsArray[] = $Row;
        }

        return $ResultsArray;
    }

    function printTable(\IntellivoidAccounts\IntellivoidAccounts $intellivoidAccounts)
    {

        $Page = 1;

        if(isset($_GET['page']))
        {
            $Page = (int)$_GET['page'];
        }

        foreach(getLoginsPage($intellivoidAccounts, $Page) as $login_record)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/edit_account?id=" . urlencode($login_record['id']) . "\">");
            \DynamicalWeb\HTML::print($login_record['id']);
            print("</a>");
            print("</th>");

            print("<td>");
            \DynamicalWeb\HTML::print(substr($login_record['public_id'], 0, 15) . '...');
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($login_record['account_id']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($login_record['ip_address']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($login_record['origin']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($login_record['time']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($login_record['status']);
            print("</td>");

            print("</tr>");
        }

    }

    function printIndex(\IntellivoidAccounts\IntellivoidAccounts $intellivoidAccounts)
    {
        $TotalPages = totalLoginPages($intellivoidAccounts);

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
            print("<a href=\"/openblu_plans?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }