<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 模型基类
 */
class Model extends ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /** @var array 可过滤字段 */
    protected static array $filterColumns = [];

    /** @var array 规律规则 */
    protected static array $filterRules = [];

    /**
     * 获取可过滤字段
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function getFilterColumns(): array
    {
        if (empty(static::$filterColumns)) {
            static::$filterColumns = static::getTableSchema()->getColumnNames();
        }

        return static::$filterColumns;
    }

    /**
     * 获取过滤规则
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function getFilterRules(): array
    {
        if (empty(static::$filterRules)) {
            $columns = static::getFilterColumns();

            static::$filterRules = [
                [[...$columns], 'trim']
            ];

            $types = [];
            foreach ($columns as $name) {
                /** @var \yii\db\ColumnSchema $column */
                $column = static::getTableSchema()->getColumn($name);

                $types[$column->phpType][] = $column->name;
            }

            foreach ($types as $type => $fields) {
                static::$filterRules[] = [[...$fields], $type];
            }
        }

        return static::$filterRules;
    }

    /**
     * 装载数据
     *
     * @param $data
     * @param $formName
     *
     * @return bool
     */
    public function load($data, $formName = null)
    {
        if (parent::load($data, $formName)) {
            $this->afterLoad();

            return true;
        }

        return false;
    }

    /**
     * 数据后处理
     *
     * @return void
     */
    public function afterLoad()
    {

    }

    /**
     * 场景管理
     *
     * @return array[]
     */
    public function scenarios()
    {
        $scenarios = [self::SCENARIO_DEFAULT => [], self::SCENARIO_CREATE => [], self::SCENARIO_UPDATE => []];
        foreach ($this->getValidators() as $validator) {
            foreach ($validator->on as $scenario) {
                $scenarios[$scenario] = [];
            }
            foreach ($validator->except as $scenario) {
                $scenarios[$scenario] = [];
            }
        }
        $names = array_keys($scenarios);

        foreach ($this->getValidators() as $validator) {
            if (empty($validator->on) && empty($validator->except)) {
                foreach ($names as $name) {
                    foreach ($validator->attributes as $attribute) {
                        $scenarios[$name][$attribute] = true;
                    }
                }
            } elseif (empty($validator->on)) {
                foreach ($names as $name) {
                    if (!in_array($name, $validator->except, true)) {
                        foreach ($validator->attributes as $attribute) {
                            $scenarios[$name][$attribute] = true;
                        }
                    }
                }
            } else {
                foreach ($validator->on as $name) {
                    foreach ($validator->attributes as $attribute) {
                        $scenarios[$name][$attribute] = true;
                    }
                }
            }
        }

        foreach ($scenarios as $scenario => $attributes) {
            if (!empty($attributes)) {
                $scenarios[$scenario] = array_keys($attributes);
            }
        }

        return $scenarios;
    }
}
