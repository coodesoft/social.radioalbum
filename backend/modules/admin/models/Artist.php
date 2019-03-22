<?php

namespace admin\models;

use backend\models\Profile;
use backend\models\ProfileOpts;

use backend\modules\album\models\Album;
use common\models\User;
use common\models\Visibility;

use Yii;

/**
 * This is the model class for table "artist".
 *
 * @property integer $id
 * @property string $begin_date
 * @property string $instrument
 * @property string $presentation
 * @property string $name
 * @property integer $profile_id
 * @property integer $user_id
 * @property string $id_referencia
 *
 * @property ArtistHasAlbum[] $artistHasAlbums
 * @property Album[] $albums
 */
class Artist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id'], 'required'],
            [['profile_id', 'user_id'], 'integer'],
            [['begin_date', 'instrument', 'id_referencia'], 'string', 'max' => 45],
            [['presentation'], 'string', 'max' => 400],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'begin_date' => 'Begin Date',
            'instrument' => 'Instrument',
            'presentation' => 'Presentation',
            'name' => 'Name',
            'profile_id' => 'Profile ID',
            'user_id' => 'User ID',
            'id_referencia' => 'Id Referencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id'])->inverseOf('artists');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('artists');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtistHasAlbums()
    {
        return $this->hasMany(ArtistHasAlbum::className(), ['artist_id' => 'id'])->inverseOf('artist');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Album::className(), ['id' => 'album_id'])->viaTable('artist_has_album', ['artist_id' => 'id']);
    }


    public function getAlbumByName($name){
      return $this->getAlbums()->where("LOWER(name) = '".strtolower($name)."'");
    }

    public static function createDefault(){
        $artist = new Artist();

        $profile = new Profile();
        $profile->name = $artist->name;
        $profile->visibility = Visibility::VPUBLIC;
        $profile->listed = true;

        $opts = new ProfileOpts();
        $opts->begin_date = 1;
        $opts->presentation = 1;
        $opts->full_name = 1;
        $opts->save();

        $profile->options_id = $opts->id;
        $profile->save();
        $artist->profile_id = $profile->id;

        return $artist;
    }
}
