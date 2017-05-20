<?php
/**
 * File: statisticsList.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/28 11:05
 * Description:
 */
?>
<tr>
    <td><?php echo $data->driver; ?></td>
    <td><?php echo $data->taxi; ?></td>
    <td><?php echo $data->date; ?></td>
    <td><?php
        switch ($data->daynight) {
            case 0:
                echo "白天";
                break;
            case 1:
                echo "夜间";
                break;
            case 2:
                echo "全天";
                break;
            default:
                echo "NULL";
        }
        ?></td>
</tr>