<?php
/**
 * file:sysInfo.php
 * author:Toruneko@outlook.com
 * date:2014-7-13
 * desc:系统信息
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">当前版本 <?php echo $this->app->params['version']; ?>
        该后台管理系统供<b><?php echo Yii::app()->name; ?></b>使用！
    </div>
    <div class="panel-body">
        <p>若有任何疑问，请联系<a href="mailto:toruneko@outlook.com">toruneko@outlook.com</a></p>
    </div>
    <ul class="list-group">
        <li class="list-group-item">操作系统：<font color="blue"><?php echo PHP_OS; ?></font></li>
        <li class="list-group-item">服务器端信息： <font color="blue"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></font></li>
        <li class="list-group-item">PHP程序版本： <font color="blue"><?php echo phpversion(); ?></font></li>
        <li class="list-group-item">数据库信息： <font
                color="blue"><?php echo $this->app->db->connectionString . '/' . Yii::app()->db->serverVersion; ?></font>
        </li>
        <li class="list-group-item">最大POST限制： <font color="blue"><?php echo ini_get("post_max_size"); ?></font></li>
        <li class="list-group-item">最大上传限制： <font color="blue"><?php echo ini_get("upload_max_filesize"); ?></font></li>
        <li class="list-group-item">最大执行时间： <font color="blue"><?php echo ini_get("max_execution_time"); ?></font></li>
        <li class="list-group-item">上传目录是否可写： <font
                color="blue"><?php echo is_writable(Yii::getPathOfAlias('webroot') . '/upload') ? '可写' : '不可写'; ?></font>
        </li>
        <li class="list-group-item">服务器时间： <font color="blue"><?php echo date("Y-m-d H:i"); ?></font></li>
    </ul>
</div>