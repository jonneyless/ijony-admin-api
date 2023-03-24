<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 模型基类
 */
class Model extends ActiveRecord
{

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
}
