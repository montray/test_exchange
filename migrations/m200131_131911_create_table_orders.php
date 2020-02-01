<?php

use yii\db\Migration;

/**
 * Class m200131_131911_create_table_orders
 */
class m200131_131911_create_table_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('orders', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(64),
            'description' => $this->text(),
            'expiresAt' => $this->dateTime(),
            'agentComission' => $this->integer(11),
            'agentId' => $this->integer(11),
            'status' => $this->tinyInteger(1),
        ]);

        $this->addForeignKey(
            'agentId_fk',
            'orders',
            'agentId',
            'users',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('agentId_fk', 'orders');
        $this->dropTable('orders');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200131_131911_create_table_orders cannot be reverted.\n";

        return false;
    }
    */
}
