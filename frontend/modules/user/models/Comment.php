<?php

namespace user\models;

use Yii;

use frontend\models\Profile;
/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property integer $profile_id
 * @property integer $post_id
 *
 * @property Post $post
 * @property Profile $profile
 */
class Comment extends \yii\db\ActiveRecord
{

  const THRESHOLD = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'post_id'], 'required'],
            [['profile_id', 'post_id'], 'integer'],
            [['content'], 'string', 'max' => 500],
            [['created_at', 'updated_at'], 'string', 'max' => 45],
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
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'profile_id' => 'Profile ID',
            'post_id' => 'Post ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id'])->inverseOf('comments');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id'])->inverseOf('comments');
    }

    /**
      * @return \yii\db\ActiveQuery
      */
    public function getCommentLikes()
    {
        return $this->hasMany(CommentLike::className(), ['comment_id' => 'id'])->inverseOf('comment');
    }

    public static function fillPosts($arrPosts){
        $queryA = Comment::find();
        foreach ($arrPosts as $key => $post) {
          if ($key == 0)
            $queryA->where(['post_id' => $post->id])->with(['commentLikes', 'profile'])->orderBy('updated_at DESC')->limit(Comment::THRESHOLD);
          else{
            $queryB = Comment::find();
            $queryB->where(['post_id' => $post->id])->with(['commentLikes', 'profile'])->orderBy('updated_at DESC')->limit(Comment::THRESHOLD);
            $queryA = $queryA->union($queryB);
          }
        }
        $comments = $queryA->all();
        $array = [];
        foreach ($arrPosts as $key => $post) {
          foreach ($comments as $key => $comment) {
            if ($post->id == $comment->post_id){
              $post->comms[] = $comment;
            }
          }
          $array[] = $post;
        }
       return $array;
    }
}
