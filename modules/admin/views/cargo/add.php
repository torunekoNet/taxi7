<?php
/**
 * File: add.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/20 11:01
 * Description:
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">添加</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'action' => $this->createUrl('cargo/add'),
            'htmlOptions' => array(
                'class' => 'form-horizontal'
            )
        )); ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'number', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'number', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'number'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'name', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'name'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'price', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'price', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'price'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'comment', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textArea($model, 'comment', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'comment'); ?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-1 col-sm-1 col-md-1 col-xs-offset-4 col-sm-offset-4 col-md-offset-4">
                <?php echo CHtml::submitButton('提交', array('class' => 'btn btn-default')); ?>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                <?php echo CHtml::resetButton('重置', array('class' => 'btn btn-default')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>