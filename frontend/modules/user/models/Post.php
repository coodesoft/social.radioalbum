<?php

namespace user\models;

use Yii;
use yii\db\Query;

use common\models\Visibility;
use frontend\models\Profile;

use frontend\modules\album\models\Album;
use frontend\modules\playlist\models\Playlist;
/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $visibility_id
 * @property integer $profile_id
 *
 * @property Comment[] $comments
 * @property Profile $profile
 */
class Post extends \yii\db\ActiveRecord
{



    public $comms = [];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id'], 'required'],
            [['profile_id', 'album_id', 'post_id', 'post_attached'], 'integer'],
            [['content'], 'string', 'max' => 500],
            [['created_at', 'updated_at', 'visibility_id'], 'string', 'max' => 45],
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
            'visibility_id' => 'Visibility ID',
            'profile_id' => 'Profile ID',
            'album_id'  => 'Album ID',
            'post_id' => 'Post ID',
            'post_attached' => 'Post Attached',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments(){
        return $this->hasMany(Comment::className(), ['post_id' => 'id'])->inverseOf('post');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile(){
        return $this->hasOne(Profile::className(), ['id' => 'profile_id'])->inverseOf('posts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum(){
        return $this->hasOne(Album::className(), ['id' => 'album_id'])->inverseOf('posts');
    }


    public function getPlaylists(){
        return $this->hasOne(Playlist::className(), ['id' => 'collection_id'])->inverseOf('posts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostLikes(){
        return $this->hasMany(PostLike::className(), ['post_id' => 'id'])->inverseOf('post');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost(){
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public static function findExtended($ids, $myId){
      $idsCondition = ['in', 'post.profile_id', $ids];
      $idsVisibilityCondition = ['or', 'post.visibility_id='.Visibility::VPROTECTED, 'post.visibility_id='.Visibility::VPUBLIC];
      $followCondition = ['and', $idsCondition, $idsVisibilityCondition];

      $publicVisibilityCondition = ['visibility_id' => Visibility::VPUBLIC];
      $notMyPostCondition = ['not', ['profile_id' => $myId]];
      $notMineAndPublicCondition = ['and', $publicVisibilityCondition, $notMyPostCondition];

      return Post::find()->where($followCondition)
                         ->orWhere($notMineAndPublicCondition)
                         ->with(['profile.listeners', 'profile.artists', 'album.artists', 'postLikes', 'post.profile', 'post.album.artists', 'post.playlists.profile'])
                         ->orderBy('updated_at DESC');
    }

    public static function findMyPosts($myId){
      return Post::find()->where(['profile_id' => $myId])
                         ->with(['profile', 'album.artists', 'postLikes',  'post.profile', 'post.album.artists', 'post.playlists.profile'])
                         ->orderBy('updated_at DESC');
    }


}
