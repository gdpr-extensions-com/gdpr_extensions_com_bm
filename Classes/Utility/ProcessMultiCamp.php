<?php

namespace GdprExtensionsCom\GdprExtensionsComBm\Utility;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;

class ProcessMultiCamp
{

    public function __construct()
    {
    }

    public function getLocationsforRoodPid(array &$params)
    {
        $helper = GeneralUtility::makeInstance(Helper::class);
        $rootpid = $helper->getRootPage($params['row']['pid']);

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $reviewsLocationQB = $connectionPool->getQueryBuilderForTable(
            'tx_gdprextensionscombm_domain_model_localbanner'
        );
        $LocationQB = $connectionPool->getQueryBuilderForTable(
            'multilocations'
        );

        $multiLocationResult = $LocationQB->select('*')
            ->from('multilocations')
            ->where(
                $LocationQB->expr()
                    ->eq('pages', $LocationQB->createNamedParameter($rootpid)),
            )
            ->executeQuery()->fetchAssociative();

        if($multiLocationResult){

            $locationResult = $reviewsLocationQB->select('*')
                ->from('tx_gdprextensionscombm_domain_model_localbanner')
                ->andWhere(
                    $reviewsLocationQB->expr()
                        ->eq('root_pid', $reviewsLocationQB->createNamedParameter($rootpid)),
                    $reviewsLocationQB->expr()
                        ->eq('dashboard_api_key', $reviewsLocationQB->createNamedParameter($multiLocationResult['dashboard_api_key'])),
                )
                ->groupBy('campaign_id')
                ->orderBy('campaign_id', 'DESC')

                ->executeQuery();

            while ($Location = $locationResult->fetchAssociative()) {

                if (strlen($Location['campaign_id']) < 1) {
                    continue;
                }
                $params['items'][] = [$Location['campaign_title'].'('.$Location['campaign_id'].')', $Location['campaign_id']];
            }

        }

        return $params;
    }

    public function getAvailableCampCount(array &$params)
    {

        $helper = GeneralUtility::makeInstance(Helper::class);
        $rootpid = $helper->getRootPage($params['record']['pid']);

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_scheduler_task');
        $taskSerilize = GeneralUtility::makeInstance(\TYPO3\CMS\Scheduler\Task\TaskSerializer::class);


        $queryBuilder->getRestrictions()->removeAll();
        $result = $queryBuilder
            ->select('*')
            ->from('tx_scheduler_task')
            ->where(
                $queryBuilder->expr()->eq('deleted', 0)
            )->executeQuery()->fetchAllAssociative();


        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $reviewsLocationQB = $connectionPool->getQueryBuilderForTable(
            'tx_gdprextensionscombm_domain_model_localbanner'
        );
        $LocationQB = $connectionPool->getQueryBuilderForTable(
            'multilocations'
        );
        $multiLocationResult = $LocationQB->select('*')
            ->from('multilocations')
            ->where(
                $LocationQB->expr()
                    ->eq('pages', $LocationQB->createNamedParameter($rootpid)),
            )
            ->executeQuery()->fetchAssociative();


        $locationResult = $reviewsLocationQB->count('*')
            ->from('tx_gdprextensionscombm_domain_model_localbanner')
            ->where(
                $reviewsLocationQB->expr()
                    ->eq('root_pid', $reviewsLocationQB->createNamedParameter($rootpid)),
            )
            ->groupBy('campaign_id')
            ->orderBy('campaign_id', 'DESC')

            ->executeQuery()->fetchAllAssociative();

        $UpdateOwnStatusTask = 0;
        $SyncBannersTask = 0;

        if(!$multiLocationResult){
            if(isset($params['conditionParameters'][0]) === true && $params['conditionParameters'][0] == 'camp'){
                return true;
            }else{
                return false;
            }
        }

        if($multiLocationResult){

            foreach ($result as $schedulerTask){

                if($taskSerilize->extractClassName($schedulerTask['serialized_task_object']) == 'GdprExtensionsCom\GdprExtensionsComCm\Commands\UpdateOwnStatusTask'){
                    $UpdateOwnStatusTask = 1;
                    $updateOwnLastExecTime = $schedulerTask['lastexecution_time'];
                    if($multiLocationResult['api_create_time'] > $updateOwnLastExecTime){
                        // need to add flag here

                        if(isset($params['conditionParameters'][0]) === true && $params['conditionParameters'][0] == 'camp'){
                            return true;
                        }else{
                            return false;
                        }
                    }
                }
                if($taskSerilize->extractClassName($schedulerTask['serialized_task_object']) == 'GdprExtensionsCom\GdprExtensionsComBm\Commands\SyncBannersTask'){
                    $SyncBannersTask = 1;
                    $bannerTaskLastExecTime = $schedulerTask['lastexecution_time'];
                    if($multiLocationResult['api_create_time'] > $bannerTaskLastExecTime){

                        if(isset($params['conditionParameters'][0]) === true && $params['conditionParameters'][0] == 'camp'){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        if (count($locationResult) <= 0){
//                        array_push($messages, 'No Campaign Found');
                        }
                    }
                }

            }
        }

        if(!$UpdateOwnStatusTask || !$SyncBannersTask){
            if(isset($params['conditionParameters'][0]) === true && $params['conditionParameters'][0] == 'camp'){
                return true;
            }else{
                return false;
            }
        }


        if(isset($params['conditionParameters'][0]) === true && $params['conditionParameters'][0] == 'camp' && count($locationResult) <= 0){
            return true;
        }

        if(isset($params['conditionParameters'][0]) === false  && count($locationResult) > 0){
            return true;
        }else{
            return false;
        }

    }

    public function getErrorMssg(array &$params, &$data)
    {
        $arrayData = (array) $data;

        $taskSerilize = GeneralUtility::makeInstance(\TYPO3\CMS\Scheduler\Task\TaskSerializer::class);
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_scheduler_task');

        $queryBuilder->getRestrictions()->removeAll();
        $result = $queryBuilder
            ->select('*')
            ->from('tx_scheduler_task')
            ->where(
                $queryBuilder->expr()->eq('deleted', 0)
            )->executeQuery()->fetchAllAssociative();



        $helper = GeneralUtility::makeInstance(Helper::class);
        $rootpid = $helper->getRootPage($arrayData["\0*\0data"]['effectivePid']);

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $reviewsLocationQB = $connectionPool->getQueryBuilderForTable(
            'tx_gdprextensionscombm_domain_model_localbanner'
        );

        $LocationQB = $connectionPool->getQueryBuilderForTable(
            'multilocations'
        );
        $multiLocationResult = $LocationQB->select('*')
            ->from('multilocations')
            ->where(
                $LocationQB->expr()
                    ->eq('pages', $LocationQB->createNamedParameter($rootpid)),
            )
            ->executeQuery()->fetchAssociative();

        $locationResult = $reviewsLocationQB->count('*')
            ->from('tx_gdprextensionscombm_domain_model_localbanner')
            ->where(
                $reviewsLocationQB->expr()
                    ->eq('root_pid', $reviewsLocationQB->createNamedParameter($rootpid)),
            )
            ->groupBy('campaign_id')
            ->orderBy('campaign_id', 'DESC')

            ->executeQuery()->fetchAllAssociative();

        $messages = [];
        $UpdateOwnStatusTask = 0;
        $SyncBannersTask = 0;

        if(!$multiLocationResult){
            array_push($messages,'Valid Api Key Not Added!');

        }
        if($multiLocationResult){
            foreach ($result as $schedulerTask){

                if($taskSerilize->extractClassName($schedulerTask['serialized_task_object']) == 'GdprExtensionsCom\GdprExtensionsComCm\Commands\UpdateOwnStatusTask'){
                    $UpdateOwnStatusTask = 1;
                    $updateOwnLastExecTime = $schedulerTask['lastexecution_time'];

                    if($multiLocationResult['api_create_time'] > $updateOwnLastExecTime){
                        // need to add flag here
                        array_push($messages,'PLease run Update Website Status Sceduler!');
                    }
                }
                if($taskSerilize->extractClassName($schedulerTask['serialized_task_object']) == 'GdprExtensionsCom\GdprExtensionsComBm\Commands\SyncBannersTask'){
                    $SyncBannersTask = 1;
                    $bannerTaskLastExecTime = $schedulerTask['lastexecution_time'];
                    if($multiLocationResult['api_create_time'] > $bannerTaskLastExecTime){
                        array_push($messages,'PLease run Fetch Banner Campaign Sceduler!');

                    }else{
                        if (count($locationResult) <= 0){
                            array_push($messages, 'No Campaign Found');
                        }
                    }
                }

            }

            if(!$UpdateOwnStatusTask){
                array_push($messages,'PLease add Update Website Status Sceduler!');
            }
            if(!$SyncBannersTask){
                array_push($messages,'PLease add Fetch Banner Campaign Sceduler!');
            }
        }

        $string = '';
        $count = 1;
        foreach ($messages as $item) {
            $string .= "(".$count++.")"." - ".$item."   \n";
        }
        return $string;

    }

}
