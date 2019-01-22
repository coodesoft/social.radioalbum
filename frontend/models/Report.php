<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property integer $id
 * @property integer $sender_id
 * @property integer $target_id
 * @property string $created_at
 * @property integer $status
 * @property integer $report_type_id
 *
 * @property ReportType $reportType
 */
class Report extends \yii\db\ActiveRecord
{

    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender_id', 'target_id', 'status', 'report_type_id'], 'integer'],
            [['created_at'], 'safe'],
            [['report_type_id'], 'required'],
            [['report_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportType::className(), 'targetAttribute' => ['report_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender ID',
            'target_id' => 'Target ID',
            'created_at' => 'Created At',
            'status' => 'Status',
            'report_type_id' => 'Report Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportType()
    {
        return $this->hasOne(ReportType::className(), ['id' => 'report_type_id'])->inverseOf('reports');
    }
}
