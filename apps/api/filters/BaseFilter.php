<?php

namespace api\filters;

use Yii;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataFilter;
use yii\data\Pagination;

/**
 * 基础筛选器
 */
class BaseFilter extends ActiveDataFilter
{

    /** @var \common\models\Model */
    public $modelClass;

    /**
     * @var Model|array|string|callable model to be used for filter attributes validation.
     */
    private $_searchModel;

    /**
     * @return Model model instance.
     * @throws InvalidConfigException on invalid configuration.
     */
    public function getSearchModel()
    {
        if (!is_object($this->_searchModel)) {
            $model = new DynamicModel;

            $columns = $this->modelClass::getFilterColumns();
            foreach ($columns as $column) {
                $model->defineAttribute($column);
            }

            $rules = $this->modelClass::getFilterRules();
            foreach ($rules as $rule) {
                $attributes = array_shift($rule);
                $validator = array_shift($rule);
                $model->addRule($attributes, $validator, $rule ?? []);
            }

            $this->_searchModel = $model;
        }

        return $this->_searchModel;
    }

    /**
     * 兼容方法
     * @return array
     */
    public function getModels()
    {
        return [];
    }

    /**
     * 兼容方法
     * @return array
     */
    public function getPagination()
    {
        return new Pagination();
    }
}