<?php

namespace common\models;

/**
 * This is the model class for table "admin".
 *
 * @property int $id 管理员 ID
 * @property string $username 账号
 * @property string $nickname 昵称
 * @property string $avatar 头像
 * @property string $password_hash 登录密码
 * @property string $auth_key 保持密钥
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $signup_at 登录时间
 * @property int $status 状态
 */
class Admin extends Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['created_at', 'updated_at', 'signup_at', 'status'], 'integer'],
            [['username'], 'string', 'max' => 24],
            [['nickname', 'password_hash'], 'string', 'max' => 64],
            [['avatar'], 'string', 'max' => 150],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '管理员 ID',
            'username' => '账号',
            'nickname' => '昵称',
            'avatar' => '头像',
            'password_hash' => '登录密码',
            'auth_key' => '保持密钥',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'signup_at' => '登录时间',
            'status' => '状态',
        ];
    }
}
