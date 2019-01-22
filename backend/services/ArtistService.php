<?php
namespace backend\services;

use yii\data\SqlDataProvider;
use yii\db\Query;

use common\services\DataService;
use frontend\modules\artist\models\Band;
use frontend\modules\artist\models\Soloist;

class ArtistService extends DataService{

  public function __construct(){
    $this->provider = new SqlDataProvider([
      'sql' => '',
      'totalCount' => 0,
      'pagination' => [
          'pageSize' => $this->pageSize,
      ],
    ]);
  }

  protected function createCustomQuery($value = null){

    $bandQuery = (new Query())
        ->select('b.name, profile.id, profile.photo')
        ->from('band b')
        ->join('LEFT JOIN', 'profile', 'b.profile_id = profile.id');

    $soloistQuery = (new Query())
    ->select(['s.name', 'profile.id', 'profile.photo'])
    ->from('soloist s')
    ->join('LEFT JOIN', 'profile', 's.profile_id = profile.id');

    $query = $bandQuery->union($soloistQuery);
    $this->provider->sql = $bandQuery->createCommand()->getRawSql();
    $this->provider->totalCount = $query->count();
  }


}
