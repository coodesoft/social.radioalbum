<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use console\rbac\UserGroupRule;
use console\rbac\PostExploreRule;
use console\rbac\PlaylistOwnerRule;
use console\rbac\PlaylistReadRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // definicion de roles que operan sobre RadioAlbum
        $admin = $auth->createRole('admin');
        $regulator = $auth->createRole('regulator');
        $artist = $auth->createRole('artist');
        $listener = $auth->createRole('listener');


        $groupRule = new UserGroupRule();
        $auth->add($groupRule);

        $admin->ruleName = $groupRule->name;
        $regulator->ruleName = $groupRule->name;
        $artist->ruleName = $groupRule->name;
        $listener->ruleName = $groupRule->name;

        //agrego los roles al authManager
        $auth->add($admin);
        $auth->add($regulator);
        $auth->add($artist);
        $auth->add($listener);

        $auth->addChild($admin, $regulator);
        $auth->addChild($artist, $listener);

     // permiso de visualización de panel lateral de acciones
        $adminPanel = $auth->createPermission('loadAdminMainPanel');
        $adminPanel->description = 'Load the Main Panel with specific admininstration items';
        $auth->add($adminPanel);
        $auth->addChild($admin, $adminPanel);

        $regulatorPanel = $auth->createPermission('loadRegulatorMainPanel');
        $regulatorPanel->description = 'Load the Main Panel with specific catalog-management items';
        $auth->add($regulatorPanel);
        $auth->addChild($regulator, $regulatorPanel);

        $artistPanel = $auth->createPermission('loadArtistMainPanel');
        $artistPanel->description = 'Load the Main Panel with specific artist-navigation items';
        $auth->add($artistPanel);
        $auth->addChild($artist, $artistPanel);

        $listenerPanel = $auth->createPermission('loadListenerMainPanel');
        $listenerPanel->description = 'Load the Main Panel with specific items for listener users';
        $auth->add($listenerPanel);
        $auth->addChild($listener, $listenerPanel);

        $loginInAdminArea = $auth->createPermission('loginInAdminArea');
        $loginInAdminArea->description = 'Login for admin/regulators users';
        $auth->add($loginInAdminArea);
        $auth->addChild($admin, $loginInAdminArea);
        $auth->addChild($regulator, $loginInAdminArea);

        $loginInPublicArea = $auth->createPermission('loginInPublicArea');
        $loginInPublicArea->description = 'Login for listeners and artists users';
        $auth->add($loginInPublicArea);
        $auth->addChild($listener, $loginInPublicArea);
        $auth->addChild($artist, $loginInPublicArea);

//####################################################################################################
        $postExplorer = $auth->createRole('postExplorer');
        $postExploreGroupRole = new PostExploreRule();
        $auth->add($postExploreGroupRole);

        $postExplorer->ruleName = $postExploreGroupRole->name;
        $auth->add($postExplorer);

        $postExplore = $auth->createPermission('postExplore');
        $postExplore->description = 'Permition for a user to see a post';
        $auth->add($postExplore);
        $auth->addChild($postExplorer, $postExplore);
//####################################################################################################
        /* Ownership de las colecciones */
        $playlistOwnerRule = new PlaylistOwnerRule();
        $auth->add($playlistOwnerRule);

        $playlistOwner = $auth->createRole('playlistOwner');
        $playlistOwner->ruleName = $playlistOwnerRule->name;
        $auth->add($playlistOwner);

        $crudPlaylist = $auth->createPermission('crudPlaylist');
        $crudPlaylist->description = 'Permition for perform CRUD operations on owned playlists';
        $auth->add($crudPlaylist);
        $auth->addChild($playlistOwner, $crudPlaylist);
//####################################################################################################
        $playlistReadRule = new PlaylistReadRule();
        $auth->add($playlistReadRule);

        $playlistReader = $auth->createRole('playlistReader');
        $playlistReader->ruleName = $playlistReadRule->name;
        $auth->add($playlistReader);

        $readPlaylist = $auth->createPermission('readPlaylist');
        $readPlaylist->description = 'Permition for reading playlists';
        $auth->add($readPlaylist);
        $auth->addChild($playlistReader, $readPlaylist);

    }

    public function actionUpdate(){
      $auth = Yii::$app->authManager;







    }
}
