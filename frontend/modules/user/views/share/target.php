<?php
use common\widgets\modalBox\ModalBox;

echo ModalBox::widget([ 'title' => \Yii::t('app', 'shareIn'),
                        'content' => $content,
                      ]);
