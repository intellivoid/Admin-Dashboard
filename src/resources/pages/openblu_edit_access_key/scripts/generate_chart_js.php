<?php

    function generateJs(\ModularAPI\Objects\AccessKey $accessKey)
    {
        $Javascript = "Morris.Line({";
        $Javascript .= "element: 'api-usage-chart',";
        $Javascript .= "parseTime: false,";
        $Javascript .= "resize: true,";
        $Javascript .= "redraw: true,";
        $Javascript .= "lineColors: ['#0088cc', '#d53f3a', '#47a447', '#5bc0de'],";

        if($accessKey->Analytics->LastMonthAvailable == true)
        {
            $data = [];

            foreach($accessKey->Analytics->CurrentMonthUsage as $key => $value)
            {
                $data[$key]['day'] = $key +1;
                $data[$key]['day'] = (string)$data[$key]['day'];
                $data[$key]['current_month'] = $value;
            }

            foreach($accessKey->Analytics->LastMonthUsage as $key => $value)
            {
                $data[$key]['day'] = $key +1;
                $data[$key]['day'] = (string)$data[$key]['day'];
                $data[$key]['last_month'] = $value;
            }

            $Javascript .= "data: " . json_encode($data) . ",";
            $Javascript .= "xkey: \"day\",";
            $Javascript .= "ykeys: ['current_month', 'last_month'],";
            $Javascript .= "labels: ['" . TEXT_API_USAGE_GRAPH_CURRENT_MONTH . "', '" . TEXT_API_USAGE_GRAPH_LAST_MONTH .  "']";
        }
        else
        {
            $data = [];

            foreach($accessKey->Analytics->CurrentMonthUsage as $key => $value)
            {
                $data[$key]['day'] = $key +1;
                $data[$key]['day'] = (string)$data[$key]['day'];
                $data[$key]['current_month'] = $value;
            }

            $Javascript .= "data: " . json_encode($data) . ",";
            $Javascript .= "xkey: \"day\",";
            $Javascript .= "ykeys: ['current_month'],";
            $Javascript .= "labels: ['Current Month']";
        }


        $Javascript .= "});";

        print("<script>$Javascript</script>");
    }
