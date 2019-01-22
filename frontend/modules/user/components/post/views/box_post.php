<?php
use yii\helpers\Url;
use common\util\StrProcessor;
use user\components\post\Post;
use user\models\Post as PostModel;


?>

      <li class="<?php echo $type ?>_cmpt_<?php echo $box['id']?> <?php echo $type ?>_cmpt <?php echo (isset($visible) && (!$visible))? 'hidden' : ''?> <?php echo $embedded ? 'embedded' : '' ?>">
          <div class="whois">
            <?php
            if (!empty($box['profile']['listeners']))
              $url = Url::to(['/listener/listener/view', 'id' => $box['profile']['listeners'][0]['id']]);

            if (!empty($box['profile']['artists']))
              $url = Url::to(['/artist/artist/view', 'id' => $box['profile']['artists'][0]['id']]);

            if ($owner_id == $box['profile_id'])
              $url = Url::to(['/user/profile']);
            ?>
              <div class="info">

                <div class="name"><a data-action="nav" href="<?php echo $url ?>"><?php echo $box['profile']['name'] . " " . $box['profile']['last_name'] ?></a></div>
                <?php $date = StrProcessor::formatDate('d/m/Y', $box['updated_at']). ' ' .StrProcessor::formatDate('h:m', $box['updated_at']) ?>
                <div class="date"><?php echo $date ?></div>
                <div class="clearfix"></div>
              </div>
          </div>
          <?php if ($owner_id == $box['profile_id'] || $owner_id == $box['post']['id']) { ?>
            <div class="remove-block">
              <a href="<?php echo Url::to(['/user/post/remove-comment', 'id' => $box['id']])?>" data-action="modal">
                <i class="far fa-times"></i>
              </a>
            </div>
          <?php } ?>
          <div class="body">
            <div class="content"><?php echo $box['content']?></div>
            <div class="reply">
              <div class="reply-text">
                <form>
                    <input type="hidden" name="Post[uid_entity]" value="<?php echo $reply_to?>">
                    <input type="hidden" name="Post[uid_propietor]" value="<?php echo $box['profile']['id']?>">
                    <?php if ($type == 'comment'){ ?>
                      <input type="hidden" name="Post[flag_control]" value="comment_cmpt_reply">
                    <?php } ?>
                    <textarea name="Post[<?php echo $type ?>]" class="text_box" rows=1 placeholder="<?php echo \Yii::t('app', 'yourOpinion?')?>"></textarea>
                </form>
              </div>
              <div class="reply-icons fa-2x">
                <?php $likes = ($type == 'post') ? count($box->postLikes) : count($box->commentLikes); ?>
                <?php
                    if (isset($profile))
                      $iLike = ($type == 'post') ? $profile->iLikePost($box['id']) : $profile->iLikeComment($box['id']);
                    else
                      $iLike = null;
                ?>

                <form class="<?php echo $type ?>-like clickeable <?php echo ($iLike) ? 'i_like' : '' ?> <?php echo ($likes) ? 'has_likes' : ''?>">
                  <input type="hidden" name="Post[uid_like]" value="<?php echo $box['id']?>">
                  <input type="hidden" name="Post[uid_propietor]" value="<?php echo $box['profile']['id']?>">
                  <input type="hidden" name="Post[uid_post]" value="<?php echo $reply_to?>">

                  <i class="fas fa-heartbeat" data-fa-transform="shrink-6"></i>
                  <div class="like-counter <?php echo (!$likes)? 'hidden' : ''?>"><?php echo $likes ?></div>
                </form>
                <?php if (isset($shareable) && $shareable) { ?>
                <form class="<?php echo $type ?>-share clickeable">
                  <input type="hidden" name="Post[uid_share]" value="<?php echo $box['id']?>">
                  <i class="fas fa-share" data-fa-transform="shrink-6"></i>
                </form>
              <?php } ?>
              </div>
            </div>
          </div>

           <?php if (isset($box['comments'])){ ?>
            <div class="comment-section <?php echo empty($box['comments']) ? 'hidden' : '' ?>">
            <ul>
              <?php
                $t = 0;
                foreach ($box['comments'] as $comment) {
                  if ( $t < PostModel::THRESHOLD/2)
                    echo Post::widget(['component' => 'comment', 'profile' => $profile,  'content' => $comment, 'shareable' => false, 'reply_to' => $box['id'], 'visible' => false]);
                  else
                    echo Post::widget(['component' => 'comment', 'profile' => $profile,  'content' => $comment, 'shareable' => false, 'reply_to' => $box['id']]);
                  $t++;
                } ?>
            </ul>
          </div>
         <?php }?>

      </li>
