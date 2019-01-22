<?php
use yii\helpers\Url;
use common\util\StrProcessor;
?>
<?php if ($content){ ?>
<?php foreach ($content as $key => $notification): ?>
  <li <?php $clickeable = (strlen($notification['clickeable'])>0) ? 'class=' . $notification['clickeable'] : ''?>>
      <div class="sender-thumb">
        <img src="<?php echo Url::to(['/ra/thumbnail', 'id' => $notification['sender_photo'], 'entity' => 'profile']) ?>"  alt="thumb-<?php echo $notification['sender_name']; ?>">
      </div>
      <div class="notifi-message">
        <div>
          <div class="paragraph"><?php echo $notification['message']?></div>
          <div class="notifi-action">
            <a href="<?php echo Url::to(['/user/social/mark-as-read', 'id' => $notification['id']])?>" data-action="social.mark-as-read">
              <?php echo $action = ($notification['status'] == 0) ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>'  ?> </div>
            </a>

        </div>
      </div>
      <div class="notifi-time text-right">
        <i class="far fa-clock"></i>
        <?php echo StrProcessor::prettyDate(time(), $notification['created_at']) ?>
        </div>
  </li>
<?php endforeach; ?>
<?php } ?>
