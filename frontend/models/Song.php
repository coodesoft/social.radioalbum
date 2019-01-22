<?php

namespace frontend\models;

use frontend\modules\album\models\Album;
use Yii;

/**
 * This is the model class for table "song".
 *
 * @property integer $id
 * @property string $name
 * @property string $url_art
 * @property string $path_song
 * @property integer $Album_id
 *
 * @property History[] $histories
 * @property PlaylistHasSong[] $playlistHasSongs
 * @property Playlist[] $playlists
 * @property Album $album
 * @property SongHasGenre[] $songHasGenres
 * @property Genre[] $genres
 */
class Song extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'song';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id'], 'required'],
            [['album_id'], 'integer'],
            [['name', 'id_referencia'], 'string', 'max' => 45],
            [['path_song'], 'string', 'max' => 400],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Album::className(), 'targetAttribute' => ['album_id' => 'id']],
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
             'path_song' => 'Path Song',
             'time' => 'Time',
             'bitrate' => 'Bitrate',
             'rate' => 'Rate',
             'size' => 'Size',
             'id_referencia' => 'Id Referencia',
             'album_id' => 'Album ID',
         ];
     }
     /**
      * @return \yii\db\ActiveQuery
      */
     public function getPlaylistHasSongs()
     {
         return $this->hasMany(PlaylistHasSong::className(), ['song_id' => 'id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getPlaylists()
     {
         return $this->hasMany(Playlist::className(), ['id' => 'playlist_id'])->viaTable('playlist_has_song', ['song_id' => 'id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getProfileHasSongs()
     {
         return $this->hasMany(ProfileHasSong::className(), ['song_id' => 'id', 'song_album_id' => 'album_id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getProfiles()
     {
         return $this->hasMany(Profile::className(), ['id' => 'profile_id'])->viaTable('profile_has_song', ['song_id' => 'id', 'song_album_id' => 'album_id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getAlbum()
     {
         return $this->hasOne(Album::className(), ['id' => 'album_id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getSongHasGenres()
     {
         return $this->hasMany(SongHasGenre::className(), ['song_id' => 'id', 'song_Album_id' => 'Album_id']);
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getGenres()
     {
         return $this->hasMany(Genre::className(), ['id' => 'genre_id'])->viaTable('song_has_genre', ['song_id' => 'id', 'song_Album_id' => 'Album_id']);
     }
   }
