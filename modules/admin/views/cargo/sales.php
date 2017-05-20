<?php
/**
 * File: sales.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/20 12:09
 * Description:
 */
$this->cs->registerScript('salesForm', "
$('#salesForm').on('click','input[type=submit]',function(){
    var form = $('#salesForm');
    $.post(form.attr('action'),form.serialize(),function(m){
        if(m.status){
            if(m.status == 200){
                var salesObj = $('.current-tr').find('.sales');
                var storeObj = $('.current-tr').find('.store');
                var sales = salesObj.html();
                var store = storeObj.html();
                var amount = $('#salesForm').find('.amount').val();
                salesObj.html(parseInt(sales) + parseInt(amount));
                storeObj.html(parseInt(store) - parseInt(amount));
            }
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
    <div class="panel-heading">出货</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'salesForm',
            'action' => $this->createUrl('cargo/sales'),
            'htmlOptions' => array(
                'class' => 'form-horizontal'
            )
        )); ?>
        <?php echo $form->hiddenField($model, 'id'); ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'number', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
            <div class="col-xs-9 col-sm-9 col-md-9">
                <p class="form-control-static"><?php echo $cargo->number; ?></p>
            </div>

        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'price', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'price', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3"><?php echo $form->error($model, 'price'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'amount', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'amount', array('class' => 'form-control amount', 'value' => 1)) ?>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3"><?php echo $form->error($model, 'amount'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'to', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textField($model, 'to', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-3"><?php echo $form->error($model, 'to'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'comment', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php echo $form->textArea($model, 'comment', array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3"><?php echo $form->error($model, 'comment'); ?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-md-3 col-xs-offset-3 col-sm-offset-3 col-md-offset-3">
                <?php echo CHtml::submitButton('提交', array('class' => 'btn btn-default')); ?>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <?php echo CHtml::resetButton('重置', array('class' => 'btn btn-default')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>