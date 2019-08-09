<?php

    use CoffeeHouse\Abstracts\PlanSearchMethod;
    use CoffeeHouse\CoffeeHouse;
    use CoffeeHouse\Exceptions\ApiPlanNotFoundException;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\LoginStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use ModularAPI\Abstracts\AccessKeySearchMethod;
    use ModularAPI\Exceptions\AccessKeyNotFoundException;
    use ModularAPI\ModularAPI;
    use OpenBlu\Exceptions\PlanNotFoundException;
    use OpenBlu\OpenBlu;

    if(isset($_GET['action']))
    {
        if($_GET['action']  == 'export_account')
        {
            if(isset($_GET['id']))
            {
                DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
                DynamicalWeb::loadLibrary('CoffeeHouse', 'CoffeeHouse', 'CoffeeHouse.php');
                DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
                $IntellivoidAccounts = new IntellivoidAccounts();
                $CoffeeHouse = new CoffeeHouse();
                $OpenBlu = new OpenBlu();

                $ExportData = [];
                $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, $_GET['id']);

                $ExportData['IntellivoidAccount'] = $Account->toArray();

                $AccountID = (int)$IntellivoidAccounts->database->real_escape_string($_GET['id']);
                $LoginRecordsQuery = "SELECT * FROM `login_records` WHERE account_id=$AccountID";
                $LoginRecordsQueryResults = $IntellivoidAccounts->database->query($LoginRecordsQuery);
                $LoginResultsArray = [];
                while($Row = $LoginRecordsQueryResults->fetch_assoc())
                {

                    $Row['public_id'] = substr($Row['public_id'], 0, 64);
                    switch($Row['status'])
                    {
                        case LoginStatus::Successful:
                            $Row['status'] = 'Successful';
                            break;

                        case LoginStatus::IncorrectCredentials:
                            $Row['status'] = 'Incorrect Credentials';
                            break;

                        case LoginStatus::IncorrectVerificationCode:
                            $Row['status'] = 'Incorrect Verification Code';
                            break;

                        default:
                            $Row['status'] = 'Unknown (' . $Row['status'] . ')';
                            break;
                    }

                    $LoginResultsArray[] = array(
                        'id' => $Row['id'],
                        'public_id' => $Row['public_id'],
                        'ip_address' => $Row['ip_address'],
                        'origin' => $Row['origin'],
                        'status' => $Row['status'],
                        'timestamp' => $Row['time']
                    );
                }
                $ExportData["LoginRecords"] = $LoginResultsArray;

                try
                {
                    $Plan = $CoffeeHouse->getApiPlanManager()->getPlan(PlanSearchMethod::byAccountId, $_GET['id']);
                    $ExportData['CoffeeHouse']["PlanDetails"] = $Plan->toArray();
                }
                catch(ApiPlanNotFoundException $apiPlanNotFoundException)
                {
                    $ExportData['CoffeeHouse']["PlanDetails"] = null;
                }


                try
                {
                    $ModularAPI = new ModularAPI();
                    $ModularAPI->Database = $CoffeeHouse->getDatabase();
                    $AccessKey = $ModularAPI->AccessKeys()->Manager->get(AccessKeySearchMethod::byID, $Plan->AccessKeyId);
                    $ExportData['CoffeeHouse']["AccessKey"] = $AccessKey->toArray();
                }
                catch(AccessKeyNotFoundException $accessKeyNotFoundException)
                {
                    $ExportData['CoffeeHouse']["AccessKey"] = null;
                }

                try
                {
                    $Plan = $OpenBlu->getPlanManager()->getPlan(PlanSearchMethod::byAccountId, $_GET['id']);
                    $ExportData['OpenBlu']["PlanDetails"] = $Plan->toArray();
                }
                catch(PlanNotFoundException $planNotFoundException)
                {
                    $ExportData['OpenBlu']["PlanDetails"] = null;
                }
                catch(\OpenBlu\Exceptions\UpdateRecordNotFoundException $updateRecordNotFoundException)
                {
                    $ExportData['OpenBlu']["PlanDetails"] = null;
                }


                try
                {
                    $ModularAPI = new ModularAPI();
                    $ModularAPI->Database = $OpenBlu->database;
                    $AccessKey = $ModularAPI->AccessKeys()->Manager->get(AccessKeySearchMethod::byID, $Plan->AccessKeyId);
                    $ExportData['OpenBlu']["AccessKey"] = $AccessKey->toArray();
                }
                catch(AccessKeyNotFoundException $accessKeyNotFoundException)
                {
                    $ExportData['OpenBlu']["AccessKey"] = null;
                }

                header('Content-disposition: attachment; filename=' . strtolower($Account->Username) . '_' . time() . '.json');
                header('Content-type: application/json');
                print(json_encode($ExportData));
                exit();
            }

        }
    }
