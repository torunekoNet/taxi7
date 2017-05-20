<?php
/**
 * File: waterList.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/20 12:29
 * Description:
 */
?>
<tr>
    <td><?php echo $data->cargo_name; ?></td>
    <td><?php echo $data->amount; ?></td>
    <td><?php echo number_format($data->price / 100, 2); ?></td>
    <?php if (isset($data->to)) { ?>
        <td><?php echo $data->to; ?></td><?php } ?>
    <td><?php echo date('Y-m-d H:i:s', $data->gmt_create); ?></td>
    <td><?php echo $data->operator; ?></td>
    <td><?php echo $data->comment; ?></td>
</tr>