<?php
/**
 * file:index.php
 * author:Toruneko@outlook.com
 * date:2014-7-14
 * desc: 日志
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">日志中心</div>
    <table class="table table-hover">
        <thead>
        <tr>
            <td>管理员</td>
            <td>URL</td>
            <td>Controller</td>
            <td>Action</td>
            <td>时间</td>
            <td>IP</td>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="6">
                <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $logging,
            'itemView' => 'loggingList',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
        </tbody>
    </table>
</div>