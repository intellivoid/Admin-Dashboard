<?php

    function lookupIP(string $ip)
    {
        $Configuration = \DynamicalWeb\DynamicalWeb::getConfiguration('configuration');
        $RequestURI = $Configuration['ip_stack']['endpoint'] . $ip . '?access_key=' . $Configuration['ip_stack']['api_key'];

        $Response = json_decode(file_get_contents($RequestURI), true);
        if($Response['success'] == false)
        {
            return array(
                'ip' => $ip,
                'hostname' => 'Unknown',
                'type' => 'Unknown',
                'continent_code' => 'Unknown',
                'continent_name' => 'Unknown',
                'country_code' => 'Unknown',
                'country_name' => 'Unknown',
                'region_code' => 'Unknown',
                'region_name' => 'Unknown',
                'city' => 'Unknown',
                'zip' => 'Unknown',
                'latitude' => 'Unknown',
                'longitude' => 'Unknown',
                'is_proxy' => 'Unknown',
                'proxy_type' => 'unknown',
                'is_tor' => 'Unknown',
                'is_crawler' => 'Unknown',
                'isp' => 'Unknown',
                'asn' => 'Unknown'
            );
        }

        $details = array(
            'ip' => $Response['ip']
        );

        if(isset($Response['hostname']))
        {
            $details['hostname'] = $Response['hostname'];
        }
        else
        {
            $details['hostname'] = 'Unknown';
        }

        if(isset($Response['type']))
        {
            $details['type'] = $Response['type'];
        }
        else
        {
            $details['type'] = 'Unknown';
        }

        if(isset($Response['continent_code']))
        {
            $details['continent_code'] = $Response['continent_code'];
        }
        else
        {
            $details['continent_code'] = 'Unknown';
        }

        return $details;
    }