<?php

use yii\db\Migration;

/**
 * Class m200131_102504_create_table_user
 */
class m200131_102504_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(11),
            'login' => $this->string(32),
            'name' => $this->string(32),
            'phone' => $this->string(32),
            'password' => $this->string(32),
            'type' => $this->string(32),
        ]);

        $this->createIndex('login_idx', 'users', 'login');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200131_102504_create_table_user cannot be reverted.\n";

        return false;
    }
    */
}
