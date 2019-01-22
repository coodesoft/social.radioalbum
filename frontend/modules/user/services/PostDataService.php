<?php
namespace user\services;

use yii\data\ActiveDataProvider;
use yii\data\Sort;
use common\services\DataService;

class PostDataService extends DataService{

  public function __construct(){
    $this->pageSize = 3;
    $this->provider = new ActiveDataProvider([
      'pagination' => [
          'pageSize' => $this->pageSize,
      ],
    ]);

    $sort = new Sort([
        'attributes' => [
            'updated_at' => [
                'default' => SORT_DESC,
                'label' => 'Updated At',
            ]
        ],
    ]);

    $this->provider->sort = $sort;
  }
}
