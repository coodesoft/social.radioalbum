<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;

use common\models\User;
use common\util\Response;
use common\util\Flags;
use common\util\ArrayProcessor;
use common\widgets\modalBox\ModalBox;

use frontend\models\Profile;
use frontend\models\ReportType;
use frontend\models\Report;
use frontend\modules\album\models\Album;
use frontend\controllers\RaBaseController;


class ReportController extends RaBaseController{


  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                    'actions' => ['load',
                                  'generate',
                                  ],
                    'allow' => true,
                    'roles' => ['listener', 'artist'],
                ],
          ],
      ],
    ];
  }

  public function actionLoad(){
    $entity = Yii::$app->request->get('entity');
    $id = Yii::$app->request->get('id');

    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    if (isset($entity) && isset($id)){
      switch ($entity) {
        case 'media':
            $reportType = ReportType::find()->where(['or', 'description="copyright"', 'description="wrong_content"'])->all();
            $content = $this->renderAjax('report', ['types' => $reportType, 'id' => $id, 'message' => Yii::t('app', 'reportProfileDescription')]);
            $title = Yii::t('app', 'reportMedia');

            return ModalBox::widget(['title' => $title, 'content' => $content]);
          break;
        case 'profile':
            $reportType = ReportType::find()->where(['or', 'description="bullying"', 'description="stolen_identity"'])->all();
            $content = $this->renderAjax('report', ['types' => $reportType, 'id' => $id, 'message' => Yii::t('app', 'reportMediaDescription')]);
            $title = Yii::t('app', 'reportProfile');

            return ModalBox::widget(['title' => $title, 'content' => $content]);
          break;
      }
    }
    return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

  }

  public function actionGenerate(){
    $type = Yii::$app->request->post('type');
    $entity = Yii::$app->request->post('entity');

    if ( !Yii::$app->request->isAjax )
      return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);

    if (isset($type) && isset($entity)){
      $report = new Report();
      $reportType = ReportType::find()->where(['description' => $type])->one();
      if ($reportType){
        $report->sender_id = User::findOne(Yii::$app->user->id)->getAssociatedModel()->profile->id;
        $report->target_id = $entity;
        $report->created_at = (string) time();
        $report->status = Report::STATUS_UNREAD;
        $report->report_type_id = $reportType->id;

        if ($report->save())
          return Response::getInstance(true, Flags::SAVE_SUCCESS)->jsonEncode();
        else
          return Response::getInstance(ArrayProcessor::toString($report->errors), Flags::SAVE_ERROR)->jsonEncode();

      } else
          return Response::getInstance(false, Flags::INVALID_ID)->jsonEncode();
    }
    return $this->renderSection('@frontend/views/ra/error', ['message' => \Yii::t('app', 'unableAccessContent')]);
  }

}
