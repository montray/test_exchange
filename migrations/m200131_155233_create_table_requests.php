<?php

use yii\db\Migration;

/**
 * Class m200131_155233_create_table_requests
 */
class m200131_155233_create_table_requests extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('requests', [
            'id' => $this->primaryKey(11),
            'userId' => $this->integer(11),
            'orderId' => $this->integer(11),
            'status' => $this->tinyInteger(1),
        ]);

        $this->addForeignKey(
            'requests_userId_fk',
            'requests',
            'userId',
            'users',
            'id'
        );
        $this->addForeignKey(
            'requests_orderId_fk',
            'requests',
            'orderId',
            'orders',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('requests_userId_fk', 'requests');
        $this->dropForeignKey('requests_orderId_fk', 'requests');

        $this->dropTable('requests');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200131_155233_create_table_requests cannot be reverted.\n";

        return false;
    }
    */
}
