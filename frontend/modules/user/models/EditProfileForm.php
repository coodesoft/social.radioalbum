<?php
namespace user\models;

use common\util\StrProcessor;
use frontend\models\Profile;

class EditProfileForm extends \yii\base\Model{

  public $id;

  public $birth_day;
  public $birth_month;
  public $birth_year;

  public $begin_day;
  public $begin_month;
  public $begin_year;

  public $photo;
  public $photo_uri;

  public function rules(){
    return [
      [['begin_day', 'begin_month', 'begin_year', 'birth_day', 'birth_month', 'birth_year'], 'integer'],
      [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, ico, jpeg'],
    ];
  }

  public function upload($old_uid){
      if ($this->validate()) {
        if ($this->photo){
          $this->photo_uri = StrProcessor::getRandomString($this->photo->baseName . '.' . $this->photo->extension);
          $this->photo->saveAs(Profile::dataPath() . $this->photo_uri);

          if (is_file(Profile::dataPath() . $old_uid))
            return unlink(Profile::dataPath() . $old_uid);

          return true;
        } else
          return true;
    } else {
        return false;
    }
  }
}
