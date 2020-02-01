<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $login
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $password
 * @property string|null $type
 *
 * @property Order[] $orders
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'name', 'phone', 'password', 'type'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'name' => 'Name',
            'phone' => 'Phone',
            'password' => 'Password',
            'type' => 'Type',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['agentId' => 'id']);
    }
}
