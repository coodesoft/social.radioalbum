<?php

namespace user\models;

use Yii;

use user\models\Post;
use frontend\models\Profile;

/**
 * This is the model class for table "post_like".
 *
 * @property integer $id
 * @property string $created_at
 * @property integer $post_id
 * @property integer $profile_id
 *
 * @property Post $post
 * @property Profile $profile
 */
class PostLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'profile_id'], 'required'],
            [['post_id', 'profile_id'], 'integer'],
            [['created_at'], 'string', 'max' => 45],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
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
            'post_id' => 'Post ID',
            'profile_id' => 'Profile ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id'])->inverseOf('postLikes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id'])->inverseOf('postLikes');
    }
}
