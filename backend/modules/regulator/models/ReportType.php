<?php

namespace regulator\models;

use Yii;

/**
 * This is the model class for table "report_type".
 *
 * @property integer $id
 * @property string $description
 *
 * @property Report[] $reports
 */
class ReportType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::className(), ['report_type_id' => 'id'])->inverseOf('reportType');
    }
}
