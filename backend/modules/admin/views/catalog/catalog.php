<?php
use admin\assets\CatalogAsset;
use yii\helpers\Url;

CatalogAsset::register($this);
?>
<div class="ra-container" id="migrationArea">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title text-center"><?php echo \Yii::t('app','areaMigMusica') ?></h3>
    </div>
    <div class="panel-body">
      <div class="panel panel-default">
        <div class="panel-heading"><?php echo \Yii::t('app', 'catalogGeneralAnalisis') ?></div>
        <div class="panel-body">
          <div class="text-center">
              <a class="init-analisis btn ra-btn" href="<?php echo $analisisChannels ?>"><?php echo \Yii::t('app','initAnalisisChannels') ?></a>
              <a class="init-analisis btn ra-btn" href="<?php echo $analisisAlbums ?>"><?php echo \Yii::t('app','initAnalisisAlbums') ?></a>
              <a class="init-analisis btn ra-btn" href="<?php echo $analisisArtists ?>"><?php echo \Yii::t('app','initAnalisisArtists') ?></a>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading"><?php echo \Yii::t('app', 'artistas') ?></div>
        <div class="panel-body">
          <div class="text-center">
            <a href="<?php echo $importPhotoArtist ?>" class="init-analisis btn ra-btn"><?php echo \Yii::t('app', 'importPhotoArtist')?></a>
          </div>
        </div>
      </div>

      <div id="analisisResult">
        <div class="results"></div>
        <div id="analisisLoader" class="text-center">
          <img  src="<?php echo Url::to(['/img/loader.gif'])?>"  alt="loader">
        </div>
      </div>
    </div>
  </div>
</div>
