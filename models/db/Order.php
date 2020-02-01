<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $expiresAt
 * @property int|null $agentComission
 * @property int|null $agentId
 * @property int|null $status
 *
 * @property User $agent
 * @property Request[] $requests
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['expiresAt'], 'safe'],
            [['agentComission', 'agentId', 'status'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['agentId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['agentId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'expiresAt' => 'Expires At',
            'agentComission' => 'Agent Comission',
            'agentId' => 'Agent ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Agent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgent()
    {
        return $this->hasOne(User::className(), ['id' => 'agentId']);
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['orderId' => 'id']);
    }
}
