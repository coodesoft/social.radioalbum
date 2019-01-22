<?php
use yii\bootstrap\Tabs;
use admin\components\migrator\Migrator;
?>
<div class="panel panel-default">
  <div class="panel-body">
    <?php echo Migrator::widget(['view' => 'channels', 'collection' => $diff]) ?>
  </div>
</div>
