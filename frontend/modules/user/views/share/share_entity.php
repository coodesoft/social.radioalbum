<?php
use user\components\post\Post;
use common\widgets\modalBox\ModalBox;

echo ModalBox::widget([ 'title' => \Yii::t('app', 'shareAlbum'),
                          'content' => Post::widget([ 'component' => 'share',
                                                      'sharedType' => $type,
                                                      'sharedId' => $id,
                                                      'content' => $content,
                                                    ]),
                        ]);
