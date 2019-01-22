<?php
use admin\components\migrator\Migrator;
?>
<div class="panel panel-default">
  <div class="panel-body">
    <?php echo Migrator::widget(['view' => 'artists', 'collection' => $diff]) ?>
  </div>
</div>
