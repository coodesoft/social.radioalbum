<?php
use yii\helpers\Url;
use frontend\assets\ReportAsset;
ReportAsset::register($this);
?>

<div class="col-sm-12" id="newReport">
  <div class="paragraph"><?php echo $message ?></div>
  <form action="<?php echo Url::to(['/report/generate'])?>">

    <?php foreach ($types as $key => $type) { ?>
      <div class="radio">
        <label>
          <input type="radio" name="type" value="<?php echo $type->description ?>" checked>
          <?php echo \Yii::t('app', $type->description) ?>
        </label>
      </div>
    <?php } ?>

    <input type="hidden" name="entity" value="<?php echo $id ?>">

    <div class="col-sm-12">
      <div class="form-group text-center">
        <button type="submit" class="btn ra-btn"><?php echo \Yii::t('app', 'generateReport')?></button>
      </div>
    </div>

  </form>
</div>
