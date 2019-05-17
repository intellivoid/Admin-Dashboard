<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $OpenBlu = new \OpenBlu\OpenBlu();


    function totalPlanPages(\OpenBlu\OpenBlu $openBlu): int
    {
        $Query = "SELECT id FROM `plans`";
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

    function getPlanPage(\OpenBlu\OpenBlu $openBlu, int $page): array
    {
        $TotalPages = totalPlanPages($openBlu);

        $Query = null;
        if($page == 1)
        {
            $Query = "SELECT id, active, account_id, access_key_id, plan_type, promotion_code, monthly_calls, price_per_cycle, next_billing_cycle, billing_cycle, payment_required, plan_created, plan_started FROM `plans` LIMIT 0, 40";
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

            $Query = "SELECT id, active, account_id, access_key_id, plan_type, promotion_code, monthly_calls, price_per_cycle, next_billing_cycle, billing_cycle, payment_required, plan_created, plan_started FROM `plans` LIMIT $StartingItem, 40";
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

        foreach(getPlanPage($openBlu, $Page) as $plan)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/openblu_edit_plan?id=" . urlencode($plan['id']) . "\">");
            \DynamicalWeb\HTML::print($plan['id']);
            print("</a>");
            print("</th>");

            print("<td>");
            $Active = "False";
            if((bool)$plan['active'] == true)
            {
                $Active = 'True';
            }
            \DynamicalWeb\HTML::print($Active);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($plan['account_id']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($plan['access_key_id']);
            print("</td>");

            print("<td>");
            $PlanType = 'Unknown';

            switch($plan['plan_type'])
            {
                case \OpenBlu\Abstracts\APIPlan::Free:
                    $PlanType = 'Free';
                    break;

                case \OpenBlu\Abstracts\APIPlan::Basic:
                    $PlanType = 'Basic';
                    break;

                case \OpenBlu\Abstracts\APIPlan::Enterprise:
                    $PlanType = 'Enterprise';
                    break;

                default:
                    $PlanType = 'Unknown';
                    break;
            }
            \DynamicalWeb\HTML::print($PlanType);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($plan['promotion_code']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($plan['monthly_calls']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($plan['price_per_cycle']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($plan['next_billing_cycle']);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($plan['billing_cycle']);
            print("</td>");

            print("<td>");
            $PaymentRequired = 'False';
            if((bool)$plan['payment_required'] == true)
            {
                $PaymentRequired = 'True';
            }
            \DynamicalWeb\HTML::print($PaymentRequired);
            print("</td>");

            print("<td>");
            \DynamicalWeb\HTML::print($plan['plan_created']);
            print("</td>");

            print("<td>");
            $PlanStarted = 'False';
            if((bool)$plan['plan_started'] == true)
            {
                $PlanType = 'True';
            }
            \DynamicalWeb\HTML::print($PlanStarted);
            print("</td>");

            print("</tr>");
        }

    }

    function printIndex(\OpenBlu\OpenBlu $openBlu)
    {
        $TotalPages = totalPlanPages($openBlu);

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