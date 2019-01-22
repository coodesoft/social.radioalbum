<?php
use yii\bootstrap\Tabs;
use admin\components\migrator\Migrator;
?>
<div class="panel panel-default">
  <div class="panel-body">
    <?php echo Migrator::widget(['view' => 'songs', 'collection' => $diff]) ?>
  </div>
</div>
