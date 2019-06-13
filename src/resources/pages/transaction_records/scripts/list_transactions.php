<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\IntellivoidAccounts;

    /** @noinspection PhpUnhandledExceptionInspection */
    DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');

    function totalTransactionPages(IntellivoidAccounts $intellivoidAccounts): int
    {
        $Query = "SELECT id FROM `transaction_records`";
        if(isset($_GET['filter']))
        {
            $Filter = (int)$intellivoidAccounts->database->real_escape_string($_GET['filter']);
            $Query = "SELECT id FROM `transaction_records` WHERE account_id=$Filter";
        }

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
                return ceil($QueryResults->num_rows / 80);
            }
        }
    }

    function getTransactionPage(IntellivoidAccounts $intellivoidAccounts, int $page): array
    {
        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, public_id, account_id, amount, operator_type, type, vendor, timestamp  FROM `transaction_records` LIMIT 0, 80";

            if(isset($_GET['filter']))
            {
                $Filter = (int)$intellivoidAccounts->database->real_escape_string($_GET['filter']);
                $Query = "SELECT id, public_id, account_id, amount, operator_type, type, vendor, timestamp FROM `transaction_records` WHERE account_id=$Filter LIMIT 0, 80";
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
                $Filter = (int)$intellivoidAccounts->database->real_escape_string($_GET['filter']);
                $Query = "SELECT id, ticket_number, source, subject, ticket_status, submission_timestamp  FROM `support_tickets` WHERE ticket_status=$Filter LIMIT $StartingItem, 80";
            }
        }

        $QueryResults = $intellivoidAccounts->database->query($Query);
        if($QueryResults == false)
        {
            die($intellivoidAccounts->database->error);
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

    function printTable(IntellivoidAccounts $intellivoidAccounts)
    {

        $Page = 1;

        if(isset($_GET['page']))
        {
            $Page = (int)$_GET['page'];
        }

        foreach(getTransactionPage($intellivoidAccounts, $Page) as $transaction_record)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/view_transaction_record?id=" . urlencode($transaction_record['id']) . "\">");
            HTML::print($transaction_record['id']);
            print("</a>");
            print("</th>");

            print("<td>");
            HTML::print(substr($transaction_record['public_id'], 0, 30) . '...');
            print("</td>");

            print("<td>");
            HTML::print($transaction_record['account_id']);
            print("</td>");

            if($transaction_record['operator_type'] == \IntellivoidAccounts\Abstracts\OperatorType::Deposit)
            {
                print("<td class=\"text-success\">");
                HTML::print('$' . $transaction_record['amount']);
                print("</td>");
            }
            else
            {
                print("<td class=\"text-danger\">");
                HTML::print('-$' . $transaction_record['amount']);
                print("</td>");
            }

            print("<td>");
            HTML::print($transaction_record['type']);
            print("</td>");

            print("<td>");
            HTML::print($transaction_record['vendor']);
            print("</td>");

            print("<td>");
            HTML::print($transaction_record['timestamp']);
            print("</td>");

            print("</tr>");
        }

    }

    function printIndex(IntellivoidAccounts $intellivoidAccounts)
    {
        $TotalPages = totalTransactionPages($intellivoidAccounts);

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
            print("<a href=\"/list_transactions?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }