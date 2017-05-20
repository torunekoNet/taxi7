<?php
/**
 * File: assign.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/28 09:12
 * Description:
 */
$this->cs->registerScript('datetimepicker', "
$('.datetimepicker').datetimepicker({
    language: 'zh-CN',
    weekStart:1,
    todayBtn:true,
    todayHighlight:true,
    keyboardNavigation:true,
    autoclose:true,
    maxView:4,
    minView:2,
    format:'yyyy-mm-dd',
});
");
$this->cs->registerScript('assignForm', "
$('#assignForm').on('click','input[type=submit]',function(){
    var form = $('#assignForm');
    $.post(form.attr('action'),form.serialize(),function(m){
        if(m.status){
            $.facebox(m.info);
        }else{
            $.facebox(m);
        }
    });
    return false;
});
");
?>
<div class="panel panel-default">
    <div class="panel-heading">登记</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'assignForm',
            'action' => $this->createUrl('taxi/assign', array('id' => $taxi->id)),
            'htmlOptions' => array(
                'class' => 'form-horizontal'
            )
        )); ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'taxi', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <p class="form-control-static"><?php echo $taxi->license; ?></p>
                <?php echo $form->hiddenField($model, 'taxi', array('class' => 'form-control', 'value' => $taxi->license)) ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'driver', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->dropDownList($model, 'driver', $driverList, array('class' => 'form-control amount', 'value' => 1)) ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'datetime', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'datetime', array('class' => 'form-control datetimepicker', 'value' => date('Y-m-d'))) ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'daynight', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->dropDownList($model, 'daynight', array('白天', '夜间', '全天'), array('class' => 'form-control')) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-md-3 col-xs-offset-3 col-sm-offset-3 col-md-offset-3">
                <?php echo CHtml::submitButton('登记', array('class' => 'btn btn-default')); ?>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <?php echo CHtml::resetButton('重置', array('class' => 'btn btn-default')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12"><?php echo $form->error($model, 'datetime'); ?></div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>