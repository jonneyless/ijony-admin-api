<?php

namespace api\controllers;

use common\models\Model;
use Yii;
use yii\filters\Cors;
use yii\rest\ActiveController;

/**
 * 控制器基类
 */
class BaseController extends ActiveController
{
    /**
     * @var string the scenario used for updating a model.
     * @see \yii\base\Model::scenarios()
     */
    public $updateScenario = Model::SCENARIO_UPDATE;
    /**
     * @var string the scenario used for creating a model.
     * @see \yii\base\Model::scenarios()
     */
    public $createScenario = Model::SCENARIO_CREATE;

    /**
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'corsFilter'=>[
                'class' => Cors::class,
                'cors'=>[
                    'Access-Control-Allow-Credentials' => false,
                    'Origin' => ['*'],
                ]
            ]
        ];
    }

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
            'view' => [
                'class' => 'api\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'create' => [
                'class' => 'api\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
            'update' => [
                'class' => 'api\rest\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->updateScenario,
            ],
            'delete' => [
                'class' => 'api\rest\DeleteAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }
}
