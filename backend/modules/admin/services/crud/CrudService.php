<?php
namespace admin\services\crud;

use yii\db\ActiveRecord;
use common\util\ArrayProcessor;
abstract class CrudService{

  protected function transaction(){
    return ActiveRecord::getDb()->beginTransaction();
  }

  protected abstract function beforeAdd($obj = null);

  protected abstract function afterAdd($model, $obj, $errors);

  protected abstract function beforeRemove($obj = null);

  protected abstract function afterRemove($obj = null);

  protected abstract function beforeUpdate($obj = null);

  protected abstract function afterUpdate($params = null);

  public function add($obj){
    $errors = "";
    $transaction = $this->transaction();
    try {
      $model = $this->beforeAdd($obj);
      if (!$model->save()){
        $errors = ArrayProcessor::toString($model->errors);
      }
      $errors = $this->afterAdd($model, $obj, $errors);
      $transaction->commit();
    } catch (\Exception $e) {
      $errors = $e->getMessage();
      $transaction->rollBack();
    }
    return $errors;
  }

  public function remove($id){
    $errors = '';
    $transaction = $this->transaction();
    try {
      $model = $this->beforeRemove($id);
      if (!$model->delete()){
        $errors = ArrayProcessor::toString($model->errors);
      }
      $this->afterRemove();
      $transaction->commit();
    } catch (\Exception $e) {
      $transaction->rollBack();
      $errors = $e->getMessage();
    }
    return $errors;
  }

  public function update($id, $obj){
    $errors = '';
    $transaction = $this->transaction();
    try {
      $model = $this->beforeUpdate($obj);
      if (!$model->save()){
        $errors = ArrayProcessor::toString($model->errors);
      }
      $this->afterUpdate($obj);
      $transaction->commit();
    } catch (\Exception $e) {
        $errors = $e->getMessage();
        $transaction->rollBack();
    }
    return $errors;
  }

  public function addAll($params){
    $errors = array();
    foreach($params as $id => $obj){
      $transaction = $this->transaction();
      try {
        $model = $this->beforeAdd($obj);
        if (!$model->save()){
          $errors[] = ['id' => $id, 'error' =>  $model->errors];
        }
        $errors = $this->afterAdd($model, $obj, $errors);
        $transaction->commit();
      } catch (\Exception $e) {
        $transaction->rollBack();
        $errors = [$e->getMessage()];
      }
    }
    return $errors;
  }

  public function removeAll($params){
    $errors = array();
    foreach($params as $id){
      $transaction = $this->transaction();
      try {
        $model = $this->beforeRemove($id);
        if (!$model->delete()){
          $errors[] = ['id' => $id, 'error' =>  $model->errors];
        }
        $this->afterRemove();
        $transaction->commit();
      } catch (\Exception $e) {
        $transaction->rollBack();
      }
    }
    return $errors;
  }

  public function updateAll($params){
    $errors = array();

    foreach($params as $id => $obj){
      $transaction = $this->transaction();
      try {
        $model = $this->beforeUpdate($obj);
        if (!$model->save()){
          $errors[] = ['id' => $id, 'error' => $model->errors];
        }
        $this->afterUpdate();
        $transaction->commit();
      } catch (\Exception $e) {
          $errors[] = $e->getMessage();
          $transaction->rollBack();
      }
    }
    return $errors;
  }

}
