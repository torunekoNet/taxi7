<?php
/**
 * File: statistics.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/28 11:04
 * Description:
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">流水记录</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'action' => $this->createUrl('taxi/statistics'),
            'htmlOptions' => array(
                'class' => 'form-inline'
            )
        ));
        ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'driver', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'driver', array('class' => 'form-control', 'placeholder' => '驾驶人')) ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'taxi', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'taxi', array('class' => 'form-control', 'placeholder' => '牌照')) ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::submitButton('搜索', array('class' => 'btn btn-default')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <table class="table table-hover" id="table">
        <thead>
        <tr>
            <td>驾驶人</td>
            <td>牌照</td>
            <td>日期</td>
            <td>时段</td>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="4">
                <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $data,
            'itemView' => 'statisticsList',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
        </tbody>
    </table>
</div>