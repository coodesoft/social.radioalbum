<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Contacto';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <div class="panel panel-gral">
        <div class="panel-heading">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
			'id' => 'contact-form',
			'action' => ['mail-sender/send']
		]); ?>

		<?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'subject') ?>
                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>


            <?php ActiveForm::end(); ?>
        </div>
        <div class="panel-footer alt-pie">
            <?= Html::submitButton(\Yii::t('app','enviar'), ['class' => 'btn btn-primary btn-lg', 'name' => 'contact-button']) ?>
        </div>
    </div>
</div>
