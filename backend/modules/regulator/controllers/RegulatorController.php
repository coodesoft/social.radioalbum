<?php
namespace regulator\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\bootstrap\Tabs;

use backend\models\Profile;
use backend\controllers\RaBaseController;

use regulator\models\Report;
use regulator\models\ReportType;

use common\models\User;
use common\util\Response;
use common\util\Flags;
use common\widgets\modalBox\ModalBox;

use common\util\StrProcessor;

class RegulatorController extends RaBaseController{

  public function behaviors(){
    return [
      'access' => [
          'class' => AccessControl::className(),
          'rules' => [
                [
                  'actions' => ['reports',
                                'view-report',
                                'status-report',
                                'delete-report',
                                'status-user'],
                  'allow' => true,
                  'roles' => ['regulator', 'admin'],
                ],
          ],
      ],
    ];
  }

  public function actionReports(){
    $reports = Report::getReports();
    return $this->renderSection('reports', ['reports' => $reports]);

  }

  public function actionViewReport(){
    $id = Yii::$app->request->get('id');
    $stored = Report::findOne($id);
    if ($stored){
      $type = $stored->reportType;
      $classname = 'regulator\models\reports\\' .   StrProcessor::mapToClassName($type->description) . "Report";

      $report = $classname::init($stored);
      $sender = Profile::findOne($stored->sender_id);
      $target = $report->target->instance;

      return $this->renderSection('reports/'. $report->representation, ['sender' => $sender, 'target' => $target, 'report' => $report]);
    }
  }

  public function actionStatusReport(){
      if (!Yii::$app->request->isPost)
        return;

      $param = Yii::$app->request->post('Report');
      $report = Report::findOne($param['id']);

      if ($report){
        $report->status = ($report->status == 1) ? 0 : 1;

        $icon = (!$report->status) ? 'fa-check-circle': 'fa-times-circle';
        $statusLabel = ($report->status) ? Yii::t('app', 'processed') : Yii::t('app', 'pending');
        $btnLabel = ($report->status) ? Yii::t('app', 'markPending') : Yii::t('app', 'markProcessed');
        if ($report->save()){
          $response = [ 'id' => $param['id'],
                        'icon' => $icon,
                        'status' => $report->status,
                        'btnLabel' => $btnLabel,
                        'statusLabel' => $statusLabel,
                     ];
          return Response::getInstance($response, Flags::SAVE_SUCCESS)->jsonEncode();
        }
        return Response::getInstance(['errors' => $report->errors], Flags::SAVE_ERROR)->jsonEncode();
      }
  }

  public function actionStatusUser(){
    if (!Yii::$app->request->isPost)
      return;

      $param = Yii::$app->request->post('User');

      if (isset($param['id']) && $user = User::findOne($param['id'])){
        $profile = $user->getAssociatedModel()->profile;

        $transaction = User::getDb()->beginTransaction();

        $status = $user->isActive() ? false : true;
        $user->setActive($status);

        $status = $profile->isListed() ? false : true;
        $profile->setListed($status);

        $statusLabel = $profile->isListed() ? Yii::t('app', 'profileListed') : Yii::t('app', 'profileNoListed');
        $btnLabel = $profile->isListed() ? Yii::t('app', 'disableUser') : Yii::t('app', 'enableUser');

        if ($user->save() && $profile->save()){
          $transaction->commit();
          $response = [ 'statusLabel' => $statusLabel,
                        'btnLabel' => $btnLabel,
                      ];
          return Response::getInstance($response, Flags::SAVE_SUCCESS)->jsonEncode();
        }

        $transaction->rollBack();
        return Response::getInstance(['errors' => ['profile' => $profile->errors, 'user' => $user->errors]], Flags::SAVE_ERROR)->jsonEncode();
      }

  }

  public function actionDeleteReport(){
    if (!Yii::$app->request->isPost){
        $id = Yii::$app->request->get('id');
        $title = Yii::t('app', 'removeReport');
        $content = $this->renderPartial('confirm-delete', ['id' => $id]);

        return ModalBox::widget(['title' => $title, 'content' => $content]);
    } else {
        $param = Yii::$app->request->post('Report');
        $delete_confirmation = Yii::$app->request->post('delete_confirmation');

        if ($param && $delete_confirmation){
          $report = Report::findOne($param['id']);
          if (!$report)
            return Response::getInstance(null, Flags::INVALID_ID)->jsonEncode();

          if ($report->delete())
            return Response::getInstance(['id' => $param['id']], Flags::DELETE_SUCCESS)->jsonEncode();

          return Response::getInstance(['errors' => $report->errors], Flags::DELETE_ERROR)->jsonEncode();
        }
    }
  }

}
