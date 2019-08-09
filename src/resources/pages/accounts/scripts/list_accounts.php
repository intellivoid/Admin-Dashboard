<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');


    function totalAccountPages(\IntellivoidAccounts\IntellivoidAccounts $intellivoidAccounts): int
    {
        $Query = "SELECT id FROM `users`";
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
                return ceil($QueryResults->num_rows / 40);
            }
        }
    }

    function getAccountPage(\IntellivoidAccounts\IntellivoidAccounts $intellivoidAccounts, int $page): array
    {
        $TotalPages = totalAccountPages($intellivoidAccounts);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, public_id, username, email, status, creation_date FROM `users` LIMIT 0, 40";
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

            $Query = "SELECT id, public_id, username, email, status, creation_date FROM `users` LIMIT $StartingItem, 40";
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

        foreach(getAccountPage($intellivoidAccounts, $Page) as $account)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/edit_account?id=" . urlencode($account['id']) . "\">");
            \DynamicalWeb\HTML::print($account['id']);
            print("</a>");
            print("</th>");

            print("<td>");
            \DynamicalWeb\HTML::print(substr($account['public_id'], 0, 15) . '...');
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($account['username']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($account['email']);
            print("</td>");

            $Status = 'Unknown';
            switch($account['status'])
            {
                case \IntellivoidAccounts\Abstracts\AccountStatus::Active:
                    $Status = '<span class="label label-success">Active</span>';
                    break;

                case \IntellivoidAccounts\Abstracts\AccountStatus::Suspended:
                    $Status = '<span class="label label-danger">Suspended</span>';
                    break;

                case \IntellivoidAccounts\Abstracts\AccountStatus::Limited:
                    $Status = '<span class="label label-warning">Limited</span>';
                    break;

                case \IntellivoidAccounts\Abstracts\AccountStatus::VerificationRequired:
                    $Status = '<span class="label label-primary">Verification Required</span>';
                    break;
            }
            print("<td>");
            \DynamicalWeb\HTML::print($Status, false);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($account['creation_date']);
            print("</td>");

            print("<td role=\"presentation\" class=\"dropdown\">");
            ?>
            <a id="drop<?PHP \DynamicalWeb\HTML::print($account['id']); ?>" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                Actions
                <span class="caret"></span>
            </a>
            <ul id="menu3" class="dropdown-menu animated fadeInDown pull-right" role="menu" aria-labelledby="drop<?PHP \DynamicalWeb\HTML::print($account['id']); ?>">
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="/login_records&filter=<?PHP print(urlencode($account['id'])); ?>">View Login Records</a>
                </li>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="/accounts&action=export_account&id=<?PHP print(urlencode($account['id'])); ?>">Export Account Data</a>
                </li>
                <li role="presentation" class="divider"></li>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="/edit_account&id=<?PHP print(urlencode($account['id'])); ?>">Manage Account</a>
                </li>
            </ul>
            <?PHP
            print("</td>");

            print("</tr>");
        }

    }

    function printIndex(\IntellivoidAccounts\IntellivoidAccounts $intellivoidAccounts)
    {
        $TotalPages = totalAccountPages($intellivoidAccounts);

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