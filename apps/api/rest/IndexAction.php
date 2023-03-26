<?php

namespace api\rest;

use yii\data\DataFilter;

/**
 * 通用列表
 */
class IndexAction extends \yii\rest\IndexAction
{

    /**
     * @return array|\yii\data\ActiveDataProvider|\yii\data\DataFilter|null
     */
    public function prepareDataProvider()
    {
        $provider = parent::prepareDataProvider();

        if ($provider instanceof DataFilter) {
            return $provider;
        }

        $models = $provider->getModels();
        $pagination = $provider->getPagination();

        return [
            'items' => $models,
            'pager' => $this->getPager($pagination),
        ];
    }

    /**
     * @param \yii\data\Pagination $pagination
     *
     * @return array
     */
    private function getPager($pagination)
    {
        $pager = [
            'total' => $pagination->totalCount,
            'next' => '',
            'pages' => $pagination->getPageCount(),
            'per-page' => $pagination->getPageSize(),
        ];

        $nextPage = $pagination->getPage() + 1;
        if ($pagination->getPageCount() > $nextPage) {
            $pager['next'] = $pagination->createUrl($nextPage);
        }

        return $pager;
    }
}