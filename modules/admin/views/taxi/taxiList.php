<?php
/**
 * File: taxiList.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/27 19:32
 * Description:
 */
?>
<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->license; ?></td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-tasks"></span>', $this->createUrl('taxi/assign', array('id' => $data->id)), array('title' => '登记')) ?>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-trash"></span>', $this->createUrl('taxi/removeCar', array('id' => $data->id)), array('title' => '删除')) ?>
    </td>
</tr>