<?php
/**
 * File: userList.php
 * User: daijianhao@zhubajie.com
 * Date: 14-8-18 11:52
 * Description:
 */
?>
<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->username; ?>(<?php echo $data->realname; ?>)</td>
    <td><?php echo $data->nickname; ?></td>
    <td><?php echo $data->email; ?></td>
    <td><?php echo $data->last_login_time ? date('Y-m-d H:i:s', $data->last_login_time) : '暂未登录'; ?>
        /<?php echo date('Y-m-d H:i:s', $data->sign_up_time); ?></td>
    <td><?php echo $data->last_login_ip ? $data->last_login_ip : '暂无IP'; ?>/<?php echo $data->sign_up_ip; ?></td>
    <td><?php echo $data->state == 1 ? '禁用' : '正常'; ?></td>
    <td>
        <?php echo $data->state == 2 ? '' : CHtml::link('<span class="glyphicon glyphicon-edit"></span>', $this->createUrl('user/edit', array('id' => $data->id)), array('title' => '编辑')) ?>
    </td>
</tr>