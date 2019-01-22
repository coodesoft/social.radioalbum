<?php
use yii\helpers\Url;
?>

<div id="confirmReportDelete" class="col-sm-12" >
  <form action="<?php echo Url::to(['/regulator/regulator/delete-report']) ?>">
    <div class="col-sm-12 title secondary-title">
      <?php echo \Yii::t('app', 'confirmReportDelete') ?>
    </div>

    <input type="hidden" name="Report[id]" value="<?php echo $id ?>">
    <input type="hidden" name="delete_confirmation" value="1">
    <div class="col-sm-12 centered" style="margin-top: 10px">
      <button id="deleteReportBtn" class="ra-btn btn" type="submit"><?php echo \Yii::t('app', 'removeReport') ?></button>
    </div>
  </form>
</div>
<div class="clearfix"></div>
