<?php
/**
 * File: water.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/20 12:21
 * Description:
 */
$this->cs->registerScript('water', '
$("#header-bar").on("click", "a", function(){
    $.get($(this).attr("href"),function(res){
        $("#content").html(res);
    });
    return false;
});
');
?>
<div class="panel panel-default">
    <div class="panel-heading" id="header-bar">
        <?php if ($method == 'Sales') { ?>
            <a class="btn btn-default"
               href="<?php echo $this->createUrl('cargo/water', array('operationType' => 'stock')); ?>">进货</a>
            出货流水数据
        <?php } else { ?>
            <a class="btn btn-default"
               href="<?php echo $this->createUrl('cargo/water', array('operationType' => 'sales')); ?>">出货</a>
            进货流水数据
        <?php } ?>
    </div>
    <?php if ($method == 'Sales') { ?>
        <div class="panel-body">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'form',
                'method' => 'get',
                'action' => $this->createUrl('cargo/water', array('operationType' => 'sales')),
                'htmlOptions' => array(
                    'class' => 'form-horizontal'
                )
            )); ?>
            <div class="form-group">
                <?php echo CHtml::label('去向', 'to', array('class' => 'col-xs-2 col-sm-2 col-md-1 control-label')); ?>
                <div class="col-xs-4 col-sm-3 col-md-2">
                    <?php echo $form->textField($model, 'to', array('class' => 'form-control')) ?>
                </div>
                <?php echo CHtml::label('备注', 'comment', array('class' => 'col-xs-2 col-sm-2 col-md-1 control-label')); ?>
                <div class="col-xs-4 col-sm-3 col-md-2">
                    <?php echo $form->textField($model, 'comment', array('class' => 'form-control')) ?>
                </div>
                <div class="col-xs-3 col-sm-2 col-md-1">
                    <?php echo CHtml::submitButton('搜索', array('class' => 'btn btn-default')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    <?php } ?>
    <table class="table table-hover" id="table">
        <thead>
        <tr>
            <td width="20%">名称</td>
            <td width="5%">数量</td>
            <td width="10%">单价</td>
            <?php if ($method == 'Sales') { ?>
                <td width="10%">去向</td><?php } ?>
            <td width="10%">时间</td>
            <td width="10%">操作人</td>
            <td>备注</td>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="<?php echo $method == 'Sales' ? 7 : 6; ?>">
                <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $data,
            'itemView' => 'waterList',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
        </tbody>
    </table>
</div>