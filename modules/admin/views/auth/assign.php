<?php
/**
 * File: assign.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 13:33
 * Description:
 */
$this->cs->registerScript('assign', "
var uri = '" . $this->createUrl('auth/assign') . "';
var roleId = " . $role->getId() . ";

$('.check-all').on('change',function(){
    $.post(uri, {role:roleId,operation:$(this).val()}, function(m){
        if(m.status){
            $.facebox(m.info);
        }
    });
});
$('.check').on('change',function(){
    $.post(uri, {role:roleId,operation:$(this).val()}, function(m){
        if(m.status){
            $.facebox(m.info);
        }
    });
});
");
?>
<fieldset>
    <h2><?php echo $role->getName(); ?></h2>
    <?php foreach ($opera as $value) {
        $item = $value['data'];
        ?>
        <div>
            <h4>
                <?php echo $item->getName(); ?>
                <?php echo CHtml::checkBox('', in_array($item->getId(), $assign), array('class' => 'check-all', 'title' => $item->getDescription(), 'value' => $item->getId())); ?>
            </h4>
            <?php foreach ($value['child'] as $key => $val) { ?>
                <?php echo CHtml::checkBox('', in_array($val->getId(), $assign), array('class' => 'check', 'title' => $val->getDescription(), 'value' => $val->getId())); ?>
                <?php echo $val->getName(); ?>
                <?php if ($key % 5 == 4) { ?><br/><?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
</fieldset>