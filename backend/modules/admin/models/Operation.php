<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "operation".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 */
class Operation extends \yii\db\ActiveRecord{
    const STATUS_INITIAL = 0;
    const STATUS_PARTIAL = 5;
    const STATUS_COMPLETE = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INITIAL],
            ['status', 'in', 'range' => [self::STATUS_INITIAL, self::STATUS_PARTIAL, self::STATUS_COMPLETE]],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
        ];
    }
}
