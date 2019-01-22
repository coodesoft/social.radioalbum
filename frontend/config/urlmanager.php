<?php

return [
  'class' => 'yii\web\UrlManager',
  'enablePrettyUrl' => true,
  'showScriptName'  => false,
  'rules' => [

      '/' => 'ra/main',

      'debug/<controller>/<action>' => 'debug/<controller>/<action>',

      'ra/<action:(channels|artists|albums|songs)>' => 'ra/<action>',

      'explore/albums' => 'album/album/list',

      'explore/channels' => 'channel/channel/list',

      'explore/artists' => 'artist/artist/list',

      'explore/collections' => 'playlist/playlist/list',

      'album/<id:\d+>' => 'album/album/view',

      'artist/<id:\d+>' => 'artist/artist/view',

      'channel/<id:\d+>' => 'channel/channel/view',

      'modal/<action>/<id:\d+>' => '/user/user/modal',

      '<action:(profile|history|favorites|albums|edit)>' => 'user/user/<action>',

      'my-collections' => 'user/user/playlists',

      'import-collection/<id:\d+>' => 'user/user/import-playlist',

      'create-collection/<id:\d+>' => 'user/user/create-playlist',

      'upload-area' => 'user/artist-upload/add',

      'share/<content:\w+>/<id:\d+>' => 'user/share/target',

      'remove-post/<id:\d+>' => 'user/post/remove-post',

      'remove-comment/<id:\d+>' => 'user/post/remove-comment',

      'create-content/<content:\w+>/<id:\d+>' => 'user/share/modal',

      'wall' => 'user/post/wall',

      'post/<id:\d+>' => 'user/post/view',

      '<action>/<id:\d+>' => 'user/social/<action>',

      'collection/view/<id:\d+>' => 'playlist/playlist/view',

      'collection/update' => 'playlist/playlist/update',
      'collection/create' => 'playlist/playlist/create',

      'collection/<id:\d+>/<action:(add-song|add-album)>/<song:\d+>' => 'playlist/playlist/<action>',

      'collection/modal/<action:(update|delete)>/<id:\d+>' => 'playlist/playlist/modal',

      'collection/modal/<playlist_id:\d+>/<action:(remove-from-playlist)>/<id:\d+>' => 'playlist/playlist/modal',
      [
        'pattern' => '<action>/<id:\d+>',
        'route' => 'user/social/<action>',
        'defaults' => ['id' => ''],
      ],


      'webplayer/<action:(song|channels|albums|album|album-art|linked-song|playlist)>' => 'musicPanel/music-panel/<action>',
  ]
];

?>
