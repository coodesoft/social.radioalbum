<?php
use yii\helpers\Url;
use common\util\StrProcessor;
use user\components\post\Post;
?>

<div class="previewPost">
  <div class="previewOwner">
    <?php
    if (!empty($entity['profile']['listeners']))
      $url = Url::to(['/listener/listener/view', 'id' => $entity['profile']['listeners'][0]['id']]);

    if (!empty($entity['profile']['artists']))
      $url = Url::to(['/artist/artist/view', 'id' => $entity['profile']['artists'][0]['id']]);

    if ($me == $entity['profile_id'])
      $url = Url::to(['/user/profile']);
    ?>

    <div class="thumb">
      <a data-action="nav" href="<?php echo $url ?>">
        <img src="<?php echo Url::to(['/ra/thumbnail', 'id' => $entity['profile']['photo'], 'entity' => 'profile']) ;?> " alt="thumb-<?php echo $entity['profile']['name']; ?>">
      </a>
    </div>
    <div class="name"><a data-action="nav" href="<?php echo $url ?>"><?php echo $entity['profile']['name'] . " " . $entity['profile']['last_name'] ?></a></div>
    <?php $date = StrProcessor::formatDate('d/m/Y', $entity['updated_at']) ?>
    <div class="date"> - <?php echo $date ?></div>
  </div>
  <div class="previewBody">
      <?php
        if (isset($entity['album']))
          echo Post::widget(['component' => 'album-preview', 'sharedEntity' => $entity['album'] ]);
       ?>
       <div class="postContent">
          <?php echo $entity['content'] ?>
       </div>
  </div>
</div>
