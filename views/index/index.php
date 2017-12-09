<?php
/**
 * File: index.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 2017/12/9 13:41
 * Description:
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tongdun Cloud</title>
    <link rel="stylesheet" href="//assets.toruneko.net/tdicon/iconfont.css?v=<?php echo $jsVersion ?>">
    <link rel="stylesheet" href="/assets/refrain/refrain.css?v=<?php echo $jsVersion ?>">
    <link rel="stylesheet" href="/assets/taxi7/taxi7.css?v=<?php echo $jsVersion ?>">
    <script src="//assets.toruneko.net/dll/vendor1.js?v=<?php echo $jsVersion ?>"></script>
    <script src="//assets.toruneko.net/dll/vendor2.js?v=<?php echo $jsVersion ?>"></script>
    <script>window.geffenDomain = "${homeUrl}"</script>
</head>
<body>
<div id="app">
    <div class="td-layout">
        <div id="refrain" class="refrain-header td-layout-header"></div>
        <div class="td-layout td-layout-has-sider">
            <div id="refrain-sidebar"></div>
            <div id="refrain-content" class="td-layout-content"></div>
            <div id="refrain-waiting" class="td-layout-content"></div>
        </div>
    </div>
</div>
<script src="/assets/refrain/refrain.js?v=<?php echo $jsVersion ?>"></script>
<script src="/assets/taxi7/taxi7.js?v=<?php echo $jsVersion ?>"></script>
</body>
</html>
