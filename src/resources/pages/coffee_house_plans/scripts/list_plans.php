<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');

    function totalPlanPages(\CoffeeHouse\CoffeeHouse $coffeeHouse): int
    {
        $Query = "SELECT id FROM `plans`";
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

    function getPlanPage(\CoffeeHouse\CoffeeHouse $coffeeHouse, int $page): array
    {
        $TotalPages = totalPlanPages($coffeeHouse);

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

        foreach(getPlanPage($coffeeHouse, $Page) as $plan)
        {
            print("<tr>");

            print("<th scope=\"row\">");
            print("<a href=\"/coffee_house_edit_plan?id=" . urlencode($plan['id']) . "\">");
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
            print("<a href=\"/coffee_house_edit_access_key?id=" . urlencode($plan['access_key_id']) . "\">");
            \DynamicalWeb\HTML::print($plan['access_key_id']);
            print("</a>");
            print("</td>");

            print("<td>");
            $PlanType = 'Unknown';

            switch($plan['plan_type'])
            {
                case \CoffeeHouse\Abstracts\APIPlan::Free:
                    $PlanType = 'Free';
                    break;

                case \CoffeeHouse\Abstracts\APIPlan::Basic:
                    $PlanType = 'Basic';
                    break;

                case \CoffeeHouse\Abstracts\APIPlan::Enterprise:
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

    function printIndex(\CoffeeHouse\CoffeeHouse $coffeeHouse)
    {
        $TotalPages = totalPlanPages($coffeeHouse);

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
            print("<a href=\"/coffee_house_plans?page=$CurrentPage\" aria-controls=\"datatable-buttons\">$CurrentPage</a>");
            print("</li>");

            $CurrentPage += 1;
        }
    }