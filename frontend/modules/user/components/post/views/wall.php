<?php
use yii\helpers\Url;
use common\util\StrProcessor;
use user\components\post\Post;
use user\models\Comment;
use user\components\post\PostAsset;
PostAsset::register($this);

?>

<div id="postContainer">
  <?php if (count($posts)>0) { ?>
  <ul  data-lazy-component="post-wall">
    <?php foreach ($posts as $key => $post) { ?>
        <li class="post_cmpt_<?php echo $post['id']?> post_cmpt <?php echo $embedded ? 'embedded' : '' ?>">
          <div class="whois">
            <?php
            if (!empty($post['profile']['listeners']))
              $url = Url::to(['/listener/listener/view', 'id' => $post['profile']['listeners'][0]['id']]);

            if (!empty($post['profile']['artists']))
              $url = Url::to(['/artist/artist/view', 'id' => $post['profile']['artists'][0]['id']]);

            if ($owner_id == $post['profile_id'])
              $url = Url::to(['/user/user/profile']);
            ?>
              <div class="thumb">
                <a data-action="nav" href="<?php echo $url ?>">
                  <img src="<?php echo Url::to(['/ra/thumbnail', 'id' => $post['profile']['photo'], 'entity' => 'profile']) ;?> " alt="thumb-<?php echo $post['profile']['name']; ?>">
                </a>
              </div>
              <div class="info">
                <div class="name">
                  <a data-action="nav" href="<?php echo $url ?>"><?php echo $post['profile']['name'] . " " . $post['profile']['last_name'] ?></a>
                  <?php if (isset($post['post']) && $post['post_attached']) { ?>
                      <div class="sharePostMsg">
                        <span class="italic"><?php echo \Yii::t('app', 'userSharePost') ?></span>
                        <a data-action="nav" href="<?php echo Url::to(['/user/post/view', 'id' => $post['post']['id'] ])?>">
                          <?php echo \Yii::t('app', 'postToLower') ?>
                        </a>
                      </div>
                  <?php } ?>
                </div>
                <?php $date = StrProcessor::formatDate('d/m/Y', $post['updated_at']). ' ' .StrProcessor::formatDate('h:m', $post['updated_at']) ?>
                <div class="date"><?php echo $date ?></div>
              </div>
          </div>

          <?php if ($owner_id == $post['profile_id']) { ?>
            <div class="remove-block">
              <a href="<?php echo Url::to(['/user/post/remove-post', 'id' => $post['id']])?>" data-action="modal">
                <i class="far fa-times"></i>
              </a>
            </div>
          <?php } ?>

          <div class="body">
            <div class="content">
              <?php if (isset($post['album'])) { ?>
                  <div class="album-shared">
                    <div class="thumb">
                      <a data-action="nav" href="<?php echo Url::to(['/album/album/view', 'id'=>$post['album']['id'] ])?>">
                        <img src="<?php echo Url::to(['/ra/thumbnail', 'id' => $post['album']['art'], 'entity' => 'album']);?>" alt="thumb-<?php echo $post['album']['name']; ?>">
                      </a>
                    </div>
                    <div class="album-content">
                        <div class="album-info">
                          <div class="album-artist"><a data-action="nav" href="<?php echo Url::to(['/artist/artist/view', 'id' => $post['album']['artists'][0]['id']])?>"><?php echo $post['album']['artists'][0]['name'] ?></a></div>
                          <div class="album-name"><a data-action="nav" href="<?php echo Url::to(['/album/album/view', 'id' => $post['album']['id']])?>"><?php echo $post['album']['name']?></a></div>
                        </div>
                        <div class="album-actions">
                          <a data-action="playback-collection" data-action="playback-collection" href="<?php echo Url::to(['/webplayer/album', 'id' => $post['album']['id']])?>">
                            <span class="fa-layers fa-fw fa-2x" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'playback')?>">
                              <i class="fal fa-circle"></i>
                              <i class="fas fa-play" data-fa-transform="shrink-10"></i>
                            </span>
                          </a>
                          <a data-action="modal" href="<?php echo Url::to(['/user/user/create-playlist', 'id' => $post['album']['id']])?>">
                            <span class="fa-layers fa-fw fa-2x" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'playback')?>">
                              <i class="fal fa-circle"></i>
                              <i class="fas fa-plus" data-fa-transform="shrink-10"></i>
                            </span>
                          </a>
                        </div>
                    </div>
                  </div>
              <span><?php echo $post['content']?></span>

            <?php } elseif (isset($post['playlists'])) { ?>
                  <div class="album-shared">
                    <div class="thumb">
                      <a data-action="nav" href="<?php echo Url::to(['/playlist/playlist/view', 'id'=>$post['playlists']['id'] ])?>">
                        <img src="<?php echo Url::to(['/ra/thumbnail',  'entity' => 'collection']);?>" alt="thumb-<?php echo $post['playlists']['name']; ?>">
                      </a>
                    </div>
                    <div class="album-content">
                        <div class="album-info">
                          <div class="album-artist"><a data-action="nav" href="<?php echo Url::to( [$post['playlists']['profile']->getModelRoute(), 'id' => $post['playlists']['profile']->getAssociatedModel()->id])?>"><?php echo $post['playlists']['profile']->getAssociatedModel()->name ?></a></div>
                          <div class="album-name"><a data-action="nav" href="<?php echo Url::to(['/playlist/playlist/view', 'id' => $post['playlists']['id']])?>"><?php echo $post['playlists']['name']?></a></div>
                        </div>
                        <div class="album-actions">
                          <a data-action="playback-collection" data-action="playback-collection" href="<?php echo Url::to(['/webplayer/playlist', 'id' => $post['playlists']['id']])?>">
                            <span class="fa-layers fa-fw fa-2x" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'playback')?>">
                              <i class="fal fa-circle"></i>
                              <i class="fas fa-play" data-fa-transform="shrink-10"></i>
                            </span>
                          </a>
                          <a data-action="modal" href="<?php echo Url::to(['/user/user/import-playlist', 'id' => $post['playlists']['id']])?>">
                            <span class="fa-layers fa-fw fa-2x" data-toggle="tooltip" data-placement="left" title="<?php echo \Yii::t('app', 'playback')?>">
                              <i class="fal fa-circle"></i>
                              <i class="fas fa-plus" data-fa-transform="shrink-10"></i>
                            </span>
                          </a>
                        </div>
                    </div>
                  </div>
              <span><?php echo $post['content']?></span>

              <?php } else {
                  echo $post['content'];
               }?>

             <?php
              if (isset($post['post']) && $post['post_attached']) { ?>
                <?php echo Post::widget(['component' => 'post-preview', 'sharedEntity' => $post['post'] ]); ?>
              <?php } elseif ($post['post_attached']) { ?>
                <div class="postRemoved well ra-error">
                  <?php echo \Yii::t('app', 'sharedPostRemoved') ?>
                </div>
              <?php } ?>
            </div>
            <div class="reply">
              <div class="reply-text">
                <form>
                    <input type="hidden" name="Post[uid_entity]" value="<?php echo $post['id']?>">
                    <input type="hidden" name="Post[uid_propietor]" value="<?php echo $post['profile']['id']?>">
                    <textarea name="Post[comment]" class="text_box" rows=1 placeholder="<?php echo \Yii::t('app', 'yourOpinion?')?>"></textarea>
                </form>
              </div>
              <div class="reply-icons fa-2x">
                <?php $likes = count($post->postLikes); ?>
                <form class="post-like clickeable <?php echo ($profile->iLikePost($post['id'])) ? 'i_like' : '' ?> <?php echo ($likes) ? 'has_likes' : ''?>">
                  <input type="hidden" name="Post[uid_like]" value="<?php echo $post['id']?>">
                  <input type="hidden" name="Post[uid_propietor]" value="<?php echo $post['profile']['id']?>">
                  <i class="fas fa-heartbeat" data-fa-transform="shrink-6"></i>
                  <div class="like-counter <?php echo (!$likes)? 'hidden' : ''?>"><?php echo $likes ?></div>
                </form>
                <?php if (isset($shareable) && $shareable) { ?>
                <a data-action="modal" href="<?php echo Url::to(['/user/share/modal', 'content' => 'post', 'id' => $post['id']])?>">
                  <input type="hidden" name="Post[uid_share]" value="<?php echo $post['id']?>">
                  <i class="fas fa-share" data-fa-transform="shrink-6"></i>
                </a>
              <?php } ?>
              </div>            </div>
          </div>

          <div class="comment-section <?php echo empty($post['comments']) ? 'hidden' : '' ?>">
            <?php $commentsCount = count($post->comms);
                  $toHide = ($commentsCount - Comment::THRESHOLD/2)?>

            <?php if ($commentsCount > Comment::THRESHOLD/2) { ?>
                <div class="show-more-comments clickeable">
                  <?php echo \Yii::t('app', 'showOlderComments') ?>
                </div>
            <?php } ?>

            <ul>
                <?php
                // THRESHOLD es el límite en la cantidad de comentarios que retorna la DB.
                // Si la cantidad de comentarios es mayor a 5.
                if ($commentsCount > Comment::THRESHOLD/2){
                    $t = 0;
                    //oculta los primeros 5.
                    for ($i=count($post->comms)-1; $i >=0 ; $i--) {
                      $comment = $post->comms[$i];
                      if ( $t < $toHide)
                        echo Post::widget(['component' => 'comment', 'profile' => $profile,  'content' => $comment, 'shareable' => false, 'reply_to' => $post['id'], 'visible' => false]);
                      else
                        echo Post::widget(['component' => 'comment', 'profile' => $profile,  'content' => $comment, 'shareable' => false, 'reply_to' => $post['id']]);
                      $t++;

                    }
                } else{
                  //throw new \Exception("Error Processing Request ".count($post->comments), 1);

                  for ($i=count($post->comms)-1; $i >=0 ; $i--) {
                    $comment = $post->comms[$i];
                    echo Post::widget(['component' => 'comment', 'profile' => $profile,  'content' => $comment, 'shareable' => false, 'reply_to' => $post['id']]);
                  }
                }
              ?>
            </ul>
          </div>
        </li>
    <?php } ?>
  </ul>
  <p class="text-center ra-clear">
    <?php if ($lazyLoad['visible']){ ?>
      <a data-action="lazy-load" href="<?php echo $lazyLoad['route'] ?>" class="btn ra-dark-btn" data-lazy-target="post-wall">Cargar mas</a>
      <img class="ra-hidden ra-loader-xs" src="<?php echo Url::to(["/img/loader.gif"]) ?>" alt="radioalbum loader">
    <?php } ?>
  </p>
  <?php } else { ?>
    <div class="noPosts title secondary-title">
      <?php echo \Yii::t('app', 'noNewPosts'); ?>
    </div>
  <?php } ?>
</div>
