<?php
/**
 * File: edit.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/28 00:35
 * Description: 更新用户
 */
$this->cs->registerScript('assign', "
var role = '" . $this->createUrl('auth/assignRole') . "';
var group = '" . $this->createUrl('auth/assignGroup') . "';
var userId = " . $model->id . ";

$('.check-role').on('change',function(){
    $.get(role, {user:userId,auth:$(this).val()}, function(m){
        if(m.status){
            $.facebox(m.info);
        }
    });
});
$('.check-group').on('change',function(){
    $.get(group, {user:userId,auth:$(this).val()}, function(m){
        if(m.status){
            $.facebox(m.info);
        }
    });
});

");
?>
<div class="panel panel-default">
    <div class="panel-heading">编辑</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'action' => $this->createUrl('user/edit'),
            'htmlOptions' => array(
                'class' => 'form-horizontal'
            )
        )); ?>
        <?php echo $form->hiddenField($model, 'id'); ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'username', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'disabled' => 'disabled')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'username'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'realname', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'realname', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'realname'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'nickname', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'nickname', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'nickname'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'email', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'email'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'password', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'password'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'confirm', array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->passwordField($model, 'confirm', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"><?php echo $form->error($model, 'confirm'); ?></div>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('用户组', false, array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-top: 7px;">
                <?php foreach ($groupList as $key => $item) { ?>
                    <?php echo $item->getAttribute('name'); ?>
                    <?php echo CHtml::checkBox('', in_array($item->getAttribute('id'), $group),
                        array('class' => 'check-group', 'value' => $item->getAttribute('id'))); ?>
                <?php } ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('角色', false, array('class' => 'col-xs-2 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-top: 7px;">
                <?php foreach ($roleList as $key => $item) { ?>
                    <?php echo $item->getAttribute('name'); ?>
                    <?php echo CHtml::checkBox('', in_array($item->getAttribute('id'), $role),
                        array('class' => 'check-role', 'value' => $item->getAttribute('id'))); ?>
                <?php } ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-1 col-sm-1 col-md-1 col-xs-offset-2 col-sm-offset-2 col-md-offset-2">
                <div class="checkbox">
                    <label>
                        <?php echo $form->checkBox($model, 'state'); ?>
                        <?php echo $form->label($model, 'state', array('style' => 'padding-left:0')); ?>
                    </label>
                </div>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                <div class="checkbox">
                    <label>
                        <?php echo $form->checkBox($model, 'approved'); ?>
                        <?php echo $form->label($model, 'approved', array('style' => 'padding-left:0')); ?>
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
    </div>
</div>