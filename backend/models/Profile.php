<?php

namespace backend\models;

use Yii;
use common\models\Gender;
use backend\modules\playlist\models\Playlist;
use common\models\Song;
use backend\models\ProfileOpts;
use backend\modules\artist\models\Artist;
use backend\modules\listener\models\Listener;

use user\models\Post;
use user\models\Comment;
use user\models\PostLike;
use user\models\CommentLike;
/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property string $name
 * @property string $last_name
 * @property string $birth_date
 * @property string $birth_location
 * @property resource $photo
 * @property string $mail
 * @property string $phone
 * @property string $facebook
 * @property string $twitter
 * @property integer $gender_id
 *
 * @property Band[] $bands
 * @property History[] $histories
 * @property Listener[] $listeners
 * @property Playlist[] $playlists
 * @property Gender $gender
 * @property Soloist[] $soloists
 */
class Profile extends \yii\db\ActiveRecord
{

  public static function dataPath(){
    return Yii::getAlias('@common') . '/data/profiles/';
  }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
     public function rules()
     {
         return [
             [['photo'], 'string', 'max'=>100],
             [['gender_id', 'visibility', 'listed'], 'integer'],
             [['name', 'last_name', 'birth_date', 'birth_location', 'mail', 'phone', 'facebook', 'twitter'], 'string', 'max' => 45],
             [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['gender_id' => 'id_gender']],
             [['options_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProfileOpts::className(), 'targetAttribute' => ['options_id' => 'id']],
         ];
     }

     /**
      * @inheritdoc
      */
     public function attributeLabels()
     {
         return [
             'id' => 'ID',
             'name' => \Yii::t('app', 'name'),
             'last_name' => \Yii::t('app', 'lastName'),
             'birth_date' => \Yii::t('app', 'birthDate'),
             'birth_location' => \Yii::t('app', 'birthLocation'),
             'photo' => \Yii::t('app', 'photo'),
             'mail' => \Yii::t('app', 'mail'),
             'phone' => \Yii::t('app', 'phone'),
             'facebook' => 'Facebook',
             'twitter' => 'Twitter',
             'gender_id' => \Yii::t('app', 'gender'),
             'options_id' => \Yii::t('app', 'options'),
         ];
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getArtists()
     {
         return $this->hasMany(Artist::className(), ['profile_id' => 'id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getListeners()
     {
         return $this->hasMany(Listener::className(), ['profile_id' => 'id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getPlaylists()
     {
         return $this->hasMany(Playlist::className(), ['profile_id' => 'id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getGender()
     {
         return $this->hasOne(Gender::className(), ['id_gender' => 'gender_id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getOptions()
     {
         return $this->hasOne(ProfileOpts::className(), ['id' => 'options_id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getProfileHasSongs()
     {
         return $this->hasMany(ProfileHasSong::className(), ['profile_id' => 'id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getSongs()
     {
         return $this->hasMany(Song::className(), ['id' => 'song_id', 'album_id' => 'song_album_id'])->viaTable('profile_has_song', ['profile_id' => 'id']);
     }


     /**
      * @return \yii\db\ActiveQuery
      */
     public function getPosts()
     {
         return $this->hasMany(Post::className(), ['profile_id' => 'id'])->inverseOf('profile');
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getComments()
     {
         return $this->hasMany(Comment::className(), ['profile_id' => 'id'])->inverseOf('profile');
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getPostLikes()
     {
         return $this->hasMany(PostLike::className(), ['profile_id' => 'id'])->inverseOf('profile');
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getCommentLikes()
     {
         return $this->hasMany(CommentLike::className(), ['profile_id' => 'id'])->inverseOf('profile');
     }


     public function isListed(){
       return $this->listed;
     }

     public function setListed($value = true){
       $this->listed = ($value) ? 1 : 0;
     }

     public static function resetNotificationCheck($id){
       $owner = Profile::findOne($id);
       $owner->options->notification_check = 0;
       return $owner->options->save();
     }

     public function getAssociatedModel(){

       if (!empty($this->artists))
        return $this->artists[0];

       if (!empty($this->listeners))
        return $this->listeners[0];
     }

     public function iLikePost($id){

       foreach ($this->postLikes as $key => $like) {

         if ($like->post_id == (int) $id)
          return true;
       }
       return false;
     }

     public function iLikeComment($id){
       foreach ($this->commentLikes as $key => $like) {
         if ($like->comment_id == (int) $id)
          return true;
       }
       return false;
     }
 }
