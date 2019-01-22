<?php
use common\widgets\modalBox\ModalBoxAsset;
ModalBoxAsset::register($this);
?>

<div class="modal fade in ra-mdl-<?php echo isset($type) ? $type : 'success'?>" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close ra-close-modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-head-title">
          <div class="logo-modal"></div>
          <h4 class="modal-title" id="myModalLabel"><?= $title ?></h4>
        </div>
      </div>
      <div class="modal-body">
        <?= $content ?>
      </div>
      <div class="modal-footer">
        <?= $footer ?>
      </div>

    </div>
  </div>
</div>
