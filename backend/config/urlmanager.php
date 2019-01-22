<?php

return [
  'class' => 'yii\web\UrlManager',
  'enablePrettyUrl' => true,
  'showScriptName'  => false,
  'rules' => [
      '/' => 'ra/main',
      'debug/<controller>/<action>' => 'debug/<controller>/<action>',
      'ra/<action:(channels|artists|albums|songs)>' => 'ra/<action>',
      
      'album/<id:\d+>' => 'album/album/view',
      'channel/<id:\d+>' => 'channel/channel/view',

      'user/<profile:\d+>/modal/<action>/<id:\d+>' => 'user/modal',
      'user/<action:(profile|playlists|history|favorites)>' => 'user/<action>',

      'history/remove/<id:\d+>/<time>' => 'user/remove-from-history',

      'artist/<id:\d+>' => 'artist/artist/artist',

      'playlist/<id:\d+>' => 'playlist/playlist/view',
      'playlist/<action:(create|update|delete|remove-song)>' => 'playlist/playlist/<action>',
      'playlist/<id:\d+>/<action:(add-song|add-album)>/<song:\d+>' => 'playlist/playlist/<action>',
      'playlist/modal/<action:(update|delete)>/<id:\d+>' => 'playlist/playlist/modal',
      'playlist/modal/<playlist_id:\d+>/<action:(remove-from-playlist)>/<id:\d+>' => 'playlist/playlist/modal',

      'webplayer/<action:(song|channels|albums|album|album-art|linked-song|playlist)>' => 'webplayer/music-panel/<action>',
  ]
];

?>
