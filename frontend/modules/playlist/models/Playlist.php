<?php
namespace frontend\modules\playlist\models;

use Yii;
use frontend\models\Profile;
use frontend\models\Song;
use user\models\Post as PostModel;
use common\models\Visibility;
/**
 * This is the model class for table "playlist".
 *
 * @property integer $id_playlist
 * @property string $name
 * @property integer $profile_id
 * @property integer $visibility_id
 *
 * @property Profile $profile
 * @property Visibility $visibility
 * @property PlaylistHasSong[] $playlistHasSongs
 * @property Song[] $songs
 */


class Playlist extends \yii\db\ActiveRecord{

    const FAVORITES = 'Favoritos';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'playlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'visibility_id'], 'required'],
            [['id', 'profile_id', 'visibility_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['visibility_id'], 'exist', 'skipOnError' => true, 'targetClass' => Visibility::className(), 'targetAttribute' => ['visibility_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id Playlist',
            'name' => 'Name',
            'profile_id' => 'Profile ID',
            'visibility_id' => 'Visibility ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisibility()
    {
        return $this->hasOne(Visibility::className(), ['id' => 'visibility_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylistHasSongs()
    {
        return $this->hasMany(PlaylistHasSong::className(), ['playlist_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongs()
    {
        return $this->hasMany(Song::className(), ['id' => 'song_id'])->viaTable('playlist_has_song', ['playlist_id' => 'id']);
    }

    public function getPosts()
    {
        return $this->hasMany(PostModel::className(), ['album_id' => 'id'])->inverseOf('playlist');
    }

    public static function findExtended($ids, $myId, $toSearch = null){
      $idsCondition = ['in', 'playlist.profile_id', $ids];
      $idsVisibilityCondition = ['or', 'playlist.visibility_id='.Visibility::VPROTECTED, 'playlist.visibility_id='.Visibility::VPUBLIC];
      $followCondition = ['and', $idsCondition, $idsVisibilityCondition];

      $publicVisibilityCondition = ['visibility_id' => Visibility::VPUBLIC];
      $notMyPostCondition = ['not', ['profile_id' => $myId]];
      $notMineAndPublicCondition = ['and', $publicVisibilityCondition, $notMyPostCondition];


      if ( $toSearch == null ){
        return Playlist::find()->where($followCondition)
                         ->orWhere($notMineAndPublicCondition)
                         ->with(['profile.listeners', 'profile.artists']);
      }else{
        $orGeneralCondition = ['or', $followCondition, $notMineAndPublicCondition];
        return Playlist::find()->where(['like', 'name', $toSearch])
                         ->andWhere($orGeneralCondition)
                         ->with(['profile.listeners', 'profile.artists']);
      }
    }
}
