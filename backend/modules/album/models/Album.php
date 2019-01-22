<?php

namespace backend\modules\album\models;

use backend\models\Song;
use backend\models\Genre;
use backend\models\Channel;

use backend\modules\artist\models\Artist;

use Yii;

/**
 * This is the model class for table "album".
 *
 * @property integer $id
 * @property string $name
 * @property string $year
 * @property string $id_referencia
 *
 * @property AlbumHasChannel[] $albumHasChannels
 * @property Channel[] $channels
 * @property AlbumHasGenre[] $albumHasGenres
 * @property Genre[] $genres
 * @property ArtistHasAlbum[] $artistHasAlbums
 * @property Artist[] $artists
 * @property Song[] $songs
 */
class Album extends \yii\db\ActiveRecord
{


   public static function dataPath(){
     return Yii::getAlias('@common') . '/data/albums/';
   }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 200],
            [['art'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 400],
            [['year', 'id_referencia'], 'string', 'max' => 45],
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
            'art' => 'Art',
            'year' => 'Year',
            'id_referencia' => 'Id Referencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumHasChannels()
    {
        return $this->hasMany(AlbumHasChannel::className(), ['album_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannels()
    {
        return $this->hasMany(Channel::className(), ['id' => 'channel_id'])->viaTable('album_has_channel', ['album_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumHasGenres()
    {
        return $this->hasMany(AlbumHasGenre::className(), ['album_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::className(), ['id' => 'genre_id'])->viaTable('album_has_genre', ['album_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtistHasAlbums()
    {
        return $this->hasMany(ArtistHasAlbum::className(), ['album_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtists()
    {
        return $this->hasMany(Artist::className(), ['id' => 'artist_id'])->viaTable('artist_has_album', ['album_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongs()
    {
        return $this->hasMany(Song::className(), ['album_id' => 'id']);
    }
}
