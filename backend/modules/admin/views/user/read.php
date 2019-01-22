<?php
use yii\widgets\DetailView;

$userView = DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'username',
        [
          'label' => \Yii::t('app', 'lastAccess'),
          'value' => \Yii::$app->formatter->asDateTime($model->access->last_access, 'medium'),
        ],
        'created_at:datetime',
        'updated_at:datetime',
        [
          'label' => \Yii::t('app', 'role'),
          'value' => $model->role->type
        ],
    ],
]);
$associated = $model->getAssociatedModel();
$gender = null;
if (isset($associated->profile->gender))
  $gender = $associated->profile->gender->type;

if ($associated){
    $profileView = DetailView::widget([
      'model' => $associated->profile,
      'attributes' =>[
        'id',
        'name',
        'last_name',
        'birth_date',
        'birth_location',

        [
          'label' => \Yii::t('app', 'photo'),
          'value' => 'data:image/jpeg;base64,'. base64_encode($associated->profile->photo),
          'format' => ['image',['width'=>'200','height'=>'200']],
        ],
        'mail',
        'phone',
        'facebook',
        'twitter',
        [
          'label' => \Yii::t('app', 'gender'),
          'value' => $gender,
        ]
      ]
    ]);
}
?>

<div class="row">
  <div class="col-md-12">
    <?php echo $userView ?>
    <div class="panel panel-default">
      <div class="panel-heading text-center"><?php echo \Yii::t('app', 'assocProfile') ?></div>
      <div class="panel-body">
          <?php echo $profile = isset($profileView) ? $profileView : \Yii::t('app', 'noAssocProfile') ?>
      </div>
    </div>
  </div>
</div>
