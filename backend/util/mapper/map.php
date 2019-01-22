<?php
return [
    'model' =>[
      'listener'  => 'backend\modules\listener\models\Listener',
      'band'      => 'backend\modules\artist\models\Band',
      'soloist'    => 'backend\modules\artist\models\Soloist',
    ],
    'route' => [
      'listener-modal' => '/listener/listener/modal',
      'band-modal' => '/artist/band/modal',
      'soloist-modal' => '/artist/soloist/modal',
    ]
];



 ?>
