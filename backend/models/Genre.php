<?php

namespace backend\models;

use backend\modules\album\models\Album;

use Yii;

/**
 * This is the model class for table "genre".
 *
 * @property integer $id
 * @property string $name
 *
 * @property AlbumHasGenre[] $albumHasGenres
 * @property Album[] $albums
 * @property SongHasGenre[] $songHasGenres
 * @property Song[] $songs
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'genre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 45],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumHasGenres()
    {
        return $this->hasMany(AlbumHasGenre::className(), ['genre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Album::className(), ['id' => 'album_id'])->viaTable('album_has_genre', ['genre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongHasGenres()
    {
        return $this->hasMany(SongHasGenre::className(), ['genre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongs()
    {
        return $this->hasMany(Song::className(), ['id' => 'song_id', 'Album_id' => 'song_Album_id'])->viaTable('song_has_genre', ['genre_id' => 'id']);
    }
}
