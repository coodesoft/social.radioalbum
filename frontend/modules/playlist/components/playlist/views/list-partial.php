<?php
use yii\helpers\Url;
?>
<?php if (!$isMobile){  ?>

       <?php foreach ($playlists as $key => $playlist): ?>
         <tr class="ra-table-item">
           <td class="actions ra-dark-row">
             <div class="action action-play" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'playback')?>">
               <a href="<?php echo  Url::to(['/webplayer/playlist', 'id'=> $playlist['id']]) ?>" data-action="playback">
                 <span class="fa-layers fa-fw table-action">
                   <i class="fal fa-circle" data-fa-transform="grow-18"></i>
                   <i class="far fa-play" data-fa-transform="shrink-3"></i>
                 </span>
               </a>
             </div>
             <div class="action action-add" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'addToCollections')?>">
               <a data-action="modal" href="<?php echo  Url::to(['/user/user/import-playlist', 'id'=>$playlist['id'] ])?>">
                 <span class="fa-layers fa-fw table-action">
                   <i class="fal fa-circle" data-fa-transform="grow-18"></i>
                   <i class="far fa-plus" data-fa-transform="shrink-3"></i>
                 </span>
               </a>
             </div>
             <div class="action action-share" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'shareCollection')?>">
               <a data-action="modal" href="<?php echo  Url::to(['/user/share/target', 'id'=>$playlist['id'], 'content' => 'collection'])?>">
                 <span class="fa-layers fa-fw table-action" data-toggle="tooltip">
                   <i class="fal fa-circle" data-fa-transform="grow-18"></i>
                   <i class="fal fa-share" data-fa-transform="shrink-3"></i>
                 </span>
               </a>
             </div>
           </td>
           <td class="ra-dark-row">
             <a data-action="nav" href="<?php echo Url::to(['/playlist/playlist/view', 'id'=>$playlist->id, 'env' => 'nav'])?>">
               <?php echo $playlist->name ?>
             </a>
           </td>
           <td class="ra-dark-row">
             <a data-action="nav" href="<?php echo Url::to([$playlist->profile->getModelRoute(), 'id'=>$playlist->profile->getAssociatedModel()->id])?>">
               <?php echo $playlist->profile->getAssociatedModel()->name; ?>
             </a>
           </td>
           <td class="ra-dark-row"><?php echo count($playlist->songs) ?></td>
         </tr>
       <?php endforeach; ?>
     <?php } else { ?>
       <?php foreach ($playlists as $key => $playlist): ?>
         <li>
           <div class="name info">
               <a data-action="nav" href="<?php echo Url::to(['/playlist/playlist/view', 'id'=>$playlist->id, 'env' => 'nav'])?>">
                 <?php echo $playlist->name ?>
               </a>
           </div>
           <div class="user info">
             <span class="strong"><?php echo \Yii::t('app', 'user') ?>: </span>
             <span class="italic">
               <a data-action="nav" href="<?php echo Url::to([$playlist->profile->getModelRoute(), 'id'=>$playlist->profile->getAssociatedModel()->id])?>">
                 <?php echo $playlist->profile->getAssociatedModel()->name; ?>
               </a>
             </span>
           </div>
           <div class="songs info">
             <span class="strong"><?php echo \Yii::t('app', 'nroSongs')?>: </span>
             <span class="italic"><?php echo count($playlist->songs) ?></span>
           </div>
           <div class="actions">
             <div class="action action-play" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'playback')?>">
               <a href="<?php echo  Url::to(['/webplayer/playlist', 'id'=> $playlist['id']]) ?>" data-action="playback">
                 <span class="fa-layers fa-fw table-action">
                   <i class="fal fa-circle" data-fa-transform="grow-18"></i>
                   <i class="far fa-play" data-fa-transform="shrink-3"></i>
                 </span>
               </a>
             </div>
             <div class="action action-add" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'addToCollections')?>">
               <a data-action="modal" href="<?php echo  Url::to(['/user/user/import-playlist', 'id'=>$playlist['id'] ])?>">
                 <span class="fa-layers fa-fw table-action">
                   <i class="fal fa-circle" data-fa-transform="grow-18"></i>
                   <i class="far fa-plus" data-fa-transform="shrink-3"></i>
                 </span>
               </a>
             </div>
             <div class="action action-share" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'shareCollection')?>">
               <a data-action="modal" href="<?php echo  Url::to(['/user/share/target', 'id'=>$playlist['id'], 'content' => 'collection'])?>">
                 <span class="fa-layers fa-fw table-action" data-toggle="tooltip">
                   <i class="fal fa-circle" data-fa-transform="grow-18"></i>
                   <i class="fal fa-share" data-fa-transform="shrink-3"></i>
                 </span>
               </a>
             </div>
           </div>
         </li>
         <div class="horizontal-separator"></div>
       <?php endforeach; ?>
     <?php } ?>
