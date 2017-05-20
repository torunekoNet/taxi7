<?php
/**
 * File: editOperation.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 23:17
 * Description:
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'form',
    'action' => $this->createUrl('auth/operationEdit'),
    'htmlOptions' => array(
        'class' => 'form-horizontal'
    )
));
echo $form->hiddenField($model, 'id');
?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'name', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <?php echo $form->textField($model, 'name', array('class' => 'form-control')) ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'name'); ?></div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'description', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <?php echo $form->textField($model, 'description', array('class' => 'form-control')) ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'description'); ?></div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'module', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <?php echo $form->textField($model, 'module', array('class' => 'form-control')) ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'module'); ?></div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'controller', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <?php echo $form->textField($model, 'controller', array('class' => 'form-control')) ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'controller'); ?></div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'action', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <?php echo $form->textField($model, 'action', array('class' => 'form-control')) ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'action'); ?></div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'sort', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <?php echo $form->textField($model, 'sort', array('class' => 'form-control')) ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'sort'); ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-3 col-sm-3 col-md-3 col-xs-offset-2 col-sm-offset-2 col-md-offset-2">
            <div class="checkbox">
                <label>
                    <?php echo $form->checkBox($model, 'status'); ?>
                    <?php echo $form->label($model, 'status', array('style' => 'padding-left:0')); ?>
                </label>
            </div>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1">
            <?php echo CHtml::submitButton('提交', array('class' => 'btn btn-default')); ?>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1">
            <?php echo CHtml::resetButton('重置', array('class' => 'btn btn-default')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>