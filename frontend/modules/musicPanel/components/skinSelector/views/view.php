<?php
namespace frontend\modules\musicPanel\components\skinSelector;

use common\widgets\RaBaseWidget;
use frontend\modules\musicPanel\components\skinSelector\skinSelector;
use frontend\modules\musicPanel\components\skinSelector\skinSelectorAsset;
use yii\helpers\Url;

$assets = skinSelectorAsset::register($this);
//$urlImg_1 = Url::to(["/img/skins.png"]); // radioalbum/site/frontend/web
?>

<div id="skinSelector" class="ss-wrapper">
  <div id="scrollHide" class="viewport">
    <ul>
      <li>
        <div id="skin_1" class="skin-item" data_skin ="a"></div>
      </li>
      <li>
        <div id="skin_2" class="skin-item" data_skin ="b"></div>
      </li>
      <li>
        <div id="skin_3" class="skin-item" data_skin ="c"></div>
      </li>
      <li>
        <div id="skin_8" class="skin-item" data_skin ="h"></div>
      </li>
      <li>
        <div id="skin_9" class="skin-item" data_skin ="i"></div>
      </li>
      <li>
        <div id="skin_11" class="skin-item" data_skin ="k"></div>
      </li>
      <li>
        <div id="skin_13" class="skin-item" data_skin ="m"></div>
      </li>
    </ul>
</div>
</div>
