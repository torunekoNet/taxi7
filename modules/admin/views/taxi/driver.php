<?php
/**
 * File: driver.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/27 19:28
 * Description:
 */
$this->cs->registerScript('addDriver', "
$('#table').on('click','tbody a',function(){
    var trash = $(this).find('.glyphicon-trash,.glyphicon-remove').length;
    var current = $(this).parent().parent();
    $.get($(this).attr('href'),function(m){
        if(m.status){
            $.facebox(m.info);
            if(trash > 0 && m.status == 200){
                current.remove();
            }
        }else{
            if(trash > 0){
                $('#content').html(m);
            }else{
                $.facebox(m);
            }
        }
    });
    return false;
});

$('#form').on('click', 'a', function(){
    $.post($(this).attr('href'), $('#form').serialize(), function(m){
        $.facebox(m.info);
        if(m.status == 200){
            $.get($('#form').attr('action'),function(m){
                $('#content').html(m);
            });
        }
    });
    return false;
});
");
?>
<div class="panel panel-default">
    <div class="panel-heading">驾驶人</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'action' => $this->createUrl('taxi/driver'),
            'htmlOptions' => array(
                'class' => 'form-inline'
            )
        ));
        ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'id', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'id', array('class' => 'form-control', 'placeholder' => '编号')) ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => '姓名')) ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::submitButton('搜索', array('class' => 'btn btn-default')); ?>
            <?php echo CHtml::link('添加', $this->createUrl('taxi/addDriver'), array('class' => 'btn btn-default', 'title' => '添加')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <table class="table table-hover" id="table">
        <thead>
        <tr>
            <td>编号</td>
            <td>姓名</td>
            <td></td>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="3">
                <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $data,
            'itemView' => 'driverList',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
        </tbody>
    </table>
</div>