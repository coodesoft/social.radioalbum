<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use common\widgets\errorMessage\ErrorMessage;
$this->title = $name;
?>
<div class="site-error">

  <?php echo ErrorMessage::widget(['message' => $message]); ?>

</div>
