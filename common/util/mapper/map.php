<?php
return [
    'model' =>[
      'listener'  => 'frontend\modules\listener\models\Listener',
      'artist'    => 'frontend\modules\artist\models\Artist',
      'channel'   => 'frontend\modules\channel\models\Channel',
      'artist'    => 'frontend\modules\artist\models\Artist',
      'album'     => 'frontend\modules\album\models\Album',
      'profile'   => 'frontend\models\Profile',
    ],
    'route' => [
      'listener'         => '/listener/listener/view',
      'artist'           => '/artist/artist/artist',
      'listener-modal'   => '/listener/listener/modal',
    ]
];



 ?>
