<?php
/**
 * file:main.php
 * author:Toruneko@outlook.com
 * date:2014-7-12
 * desc: 主视图
 */
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo CHtml::encode($this->getPageTitle()); ?></title>
    <link rel="shortcut icon" href="http://taxi7.toruneko.net/taxi7.ico" type="image/x-icon"/>

    <!--[if lt IE 9]>
    <script type="text/javascript"
            src="http://assets.toruneko.net/js/html5shiv.min.js"></script>
    <script type="text/javascript"
            src="http://assets.toruneko.net/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php echo $content; ?>
<div class="spinner" id="loading" style="display:none;">
    <div class="spinner-container container1">
        <div class="circle1"></div>
        <div class="circle2"></div>
        <div class="circle3"></div>
        <div class="circle4"></div>
    </div>
    <div class="spinner-container container2">
        <div class="circle1"></div>
        <div class="circle2"></div>
        <div class="circle3"></div>
        <div class="circle4"></div>
    </div>
    <div class="spinner-container container3">
        <div class="circle1"></div>
        <div class="circle2"></div>
        <div class="circle3"></div>
        <div class="circle4"></div>
    </div>
</div>
</body>
</html>