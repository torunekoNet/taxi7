<?php
/**
 * File: cargoList.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 18:41
 * Description:
 */
?>
<tr>
    <td><?php echo $data->number; ?></td>
    <td><?php echo $data->name; ?></td>
    <td><?php echo number_format($data->price / 100, 2); ?></td>
    <td class="last-stor"><?php echo $data->last_stor_number; ?></td>
    <td class="store"><?php echo $data->store; ?></td>
    <td class="sales"><?php echo $data->sales; ?></td>
    <td><?php echo $data->comment; ?></td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-minus"></span>', $this->createUrl('cargo/sales', array('id' => $data->id)), array('title' => '出货')) ?>
        &nbsp;&nbsp;
        <?php echo CHtml::link('<span class="glyphicon glyphicon-plus"></span>', $this->createUrl('cargo/stock', array('id' => $data->id)), array('title' => '进货')) ?>
    </td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-edit"></span>', $this->createUrl('cargo/edit', array('id' => $data->id)), array('title' => '修改')) ?>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-trash"></span>', $this->createUrl('cargo/delete', array('id' => $data->id)), array('title' => '删除')) ?>
    </td>
</tr>