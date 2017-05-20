<?php
/**
 * file:loggingList.php
 * author:Toruneko@outlook.com
 * date:2014-7-19
 * desc:日志列表
 */
?>
<tr>
    <td><?php echo $data->username ?>(<?php echo $data->user_id; ?>)</td>
    <td><?php echo $data->type . ':' . $data->request; ?></td>
    <td><?php echo $data->controller; ?></td>
    <td><?php echo $data->action; ?></td>
    <td><?php echo date('Y-m-d H:i:s', $data->time); ?></td>
    <td><?php echo $data->ip; ?></td>
</tr>