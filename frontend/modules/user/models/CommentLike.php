<?php

namespace user\models;

use Yii;

use user\models\Post;
use frontend\models\Profile;


/**
 * This is the model class for table "comment_like".
 *
 * @property integer $id
 * @property string $created_at
 * @property integer $comment_id
 * @property integer $profile_id
 *
 * @property Comment $comment
 * @property Profile $profile
 */
class CommentLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_id', 'profile_id'], 'required'],
            [['comment_id', 'profile_id'], 'integer'],
            [['created_at'], 'string', 'max' => 45],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::className(), 'targetAttribute' => ['comment_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'comment_id' => 'Comment ID',
            'profile_id' => 'Profile ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['id' => 'comment_id'])->inverseOf('commentLikes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id'])->inverseOf('commentLikes');
    }
}
