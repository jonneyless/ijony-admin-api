<?php

namespace api\controllers;

use Yii;
use yii\rest\ActiveController;

/**
 * 控制器基类
 */
class BaseController extends ActiveController
{

    /**
     * @inheritDoc
     * @return array[]
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'api\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'dataFilter' => ['class' => 'api\filters\BaseFilter', 'modelClass' => $this->modelClass],
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }
}
