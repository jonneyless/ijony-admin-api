<?php

use yii\db\Migration;

/**
 * Class m230323_172030_init
 */
class m230323_172030_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey()->unsigned()->comment('管理员 ID'),
            'username' => $this->string(24)->notNull()->comment('账号'),
            'nickname' => $this->string(64)->notNull()->defaultValue('')->comment('昵称'),
            'avatar' => $this->string(150)->notNull()->defaultValue('')->comment('头像'),
            'password_hash' => $this->string(64)->notNull()->defaultValue('')->comment('登录密码'),
            'auth_key' => $this->string(32)->notNull()->defaultValue('')->comment('保持密钥'),
            'created_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('更新时间'),
            'signup_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('登录时间'),
            'status' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0)->comment('状态'),
        ], $tableOptions . " COMMENT='管理员'");

        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey()->unsigned()->comment('菜单 ID'),
            'parent_id' => $this->integer(20)->notNull()->defaultValue(0)->comment('父级'),
            'name' => $this->string(30)->notNull()->comment('名称'),
            'icon' => $this->string(30)->notNull()->defaultValue('')->comment('图标'),
            'child' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0)->comment('有子級'),
            'parent_arr' => $this->string()->notNull()->defaultValue(0)->comment('父级链'),
            'child_arr' => $this->text()->comment('子级群'),
            'controller' => $this->string(30)->notNull()->defaultValue('')->comment('控制器'),
            'action' => $this->string(30)->notNull()->defaultValue('')->comment('方法'),
            'params' => $this->string(255)->notNull()->defaultValue('')->comment('参数'),
            'sort' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('排序'),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('状态'),
        ], $tableOptions . " COMMENT='菜单'");

        $this->createIndex('Parent Id', '{{%menu}}', 'parent_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin}}');
        $this->dropTable('{{%menu}}');
    }
}
