<?php
/**
 * File: accountList.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 10:36
 * Description:
 */
?>
<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->username; ?>(<?php echo $data->realname; ?>)</td>
    <td><?php echo $data->nickname; ?></td>
    <td><?php echo $data->email; ?></td>
    <td><?php echo $data->state == 1 ? '禁用' : '正常'; ?></td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-remove"></span>', $this->createUrl($viewTag['url'],
            array('user' => $data->id, 'auth' => $viewTag['id'])), array('title' => '移除')) ?>
    </td>
</tr>