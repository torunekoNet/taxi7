<?php
/**
 * file:nav.php
 * author:Toruneko@outlook.com
 * date:2014-7-13
 * desc:导航
 */
?>
<?php foreach ($nav as $item) { ?>
    <li><a href="<?php echo $item[1]; ?>"><?php echo $item[0]; ?></a></li>
<?php } ?>