<?php
/**
 * File: driverList.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/27 19:31
 * Description:
 */
?>
<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->name; ?></td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-search"></span>', $this->createUrl('taxi/statistics', array('id' => $data->id)), array('title' => '统计')) ?>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-trash"></span>', $this->createUrl('taxi/removeDriver', array('id' => $data->id)), array('title' => '删除')) ?>
    </td>
</tr>