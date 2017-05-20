<?php
/**
 * File: index.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 18:36
 * Description:
 */
$this->cs->registerScript('faceboxTable', '
$("#table").on("click","tbody a",function(){
    $(".current-tr").each(function(){
        $(this).removeClass("current-tr");
    });
    var title = $(this).attr("title");
    if(title == "删除"){
        if(confirm("要删除，确定不是点错了？") == false) return false;
    }
    var tr = $(this).parent().parent();
    tr.addClass("current-tr");
    $.get($(this).attr("href"), function(m){
        if(m.status){
            $.facebox(m.info);
            if(m.status == 200 && title == "删除"){
                tr.remove();
            }
        }else{
            if(title == "修改"){
                $("#content").html(m);
            }else{
                $.facebox(m,"facebox-content");
            }
        }
    });
    return false;
});
');
?>
<div class="panel panel-default">
    <div class="panel-heading">库存</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'method' => 'get',
            'action' => $this->createUrl('cargo/store'),
            'htmlOptions' => array(
                'class' => 'form-inline'
            )
        ));
        ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'number', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'number', array('class' => 'form-control', 'placeholder' => '编号')) ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => '名称')) ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::submitButton('搜索', array('class' => 'btn btn-default')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <table class="table table-hover" id="table">
        <thead>
        <tr>
            <td width="15%">编号</td>
            <td width="15%">名称</td>
            <td width="9%">建议价</td>
            <td width="9%">最近入库</td>
            <td width="9%">库存</td>
            <td width="9%">销量</td>
            <td width="15%">备注</td>
            <td width="9%">出/进</td>
            <td width="9%">改/删</td>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="9">
                <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $data,
            'itemView' => 'cargoList',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
        </tbody>
    </table>
</div>