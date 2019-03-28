<?php
namespace admin\models;

use Yii;
use yii\base\Model;

use common\util\RAFileHelper;
use common\util\Response;
use common\util\Flags;
use common\util\StrProcessor;

use backend\models\Profile;
use admin\models\Artist;
use common\models\Gender;
use common\models\Visibility;

class ArtistForm extends Model{

    public $id;

    public $art;

    public $art_name;

    public $name;

    public $description;

    public $delete_art;

    public function rules(){
        return [
            [['name'], 'required'],
            ['description', 'string', 'skipOnEmpty' => true],
            ['id', 'string', 'skipOnEmpty' => true],
            ['delete_art', 'string', 'skipOnEmpty' => true],
            [['art'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, ico, jpeg'],
        ];
    }

    public function attributeLabels(){
        return [
            'name' =>  \Yii::t('app', 'name'),
            'description' => \Yii::t('app', 'description'),
            'art' => \Yii::t('app', 'art'),
            'delete_art' => \Yii::t('app', 'deleteArt'),
        ];
    }


    public function edit($post){
      $pArtist = $post['Artist'];
      $profile = $post['Profile'];

      $gender = Gender::findOne($profile['gender_id']);
      $visibility = Visibility::findOne($profile['visibility']);


      $artist = Artist::find()->with('profile')->where( ['id' => $pArtist['id']] )->one();
      $artist->name = $pArtist['name'];
      $artist->instrument = $pArtist['instrument'];
      $artist->presentation = $pArtist['presentation'];
      $artist->begin_date = $pArtist['begin_date'];
      $artist->profile->name = $profile['name'];
      $artist->profile->last_name = $profile['last_name'];
      $artist->profile->birth_date = $profile['birth_date'];
      $artist->profile->birth_location = $profile['birth_location'];
      $artist->profile->mail = $profile['mail'];
      $artist->profile->phone = $profile['phone'];
      $artist->profile->facebook = $profile['facebook'];
      $artist->profile->twitter = $profile['twitter'];
      $artist->profile->gender_desc = $profile['gender_desc'];
      $artist->profile->listed = $profile['listed'];
      $artist->profile->gender_id = $gender->id_gender;
      $artist->profile->visibility = $visibility->id;

      $transaction = Artist::getDb()->beginTransaction();
      $upload = false;
      if ($this->art){
          $storedPhoto = $artist->profile->photo;
          if ( is_file(Profile::dataPath() . $storedPhoto) )
            unlink(Profile::dataPath() . $storedPhoto);
            
          $artist->profile->photo = StrProcessor::getRandomString($artist->name);
          $upload = $this->art->saveAs(Profile::dataPath() . $artist->profile->photo);
      }

      if ( !$artist->profile->save() ){
        $unlink = $upload ? unlink(Profile::dataPath() . $artist->profile->photo) : true;
        $response = $unlink ? Response::getInstance($artist->profile->erorrs, Flags::SAVE_ERROR) :
                              Response::getInstance($artist->profile->errors, Flags::DELETE_ERROR);

        $transaction->rollBack();
        return $response;
      }

      if ( !$artist->save() ){
        $transaction->rollBack();
        return Response::getInstance($artist->errors, Flags::UPDATE_ERROR);
      }

      $transaction->commit();
      return Response::getInstance(true, Flags::ALL_OK);
    }

}
