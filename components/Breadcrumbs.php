<?php
/**
 * file:Breadcrumbs.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc: 面包屑
 */
Yii::import('zii.widgets.CBreadcrumbs');

class Breadcrumbs extends CBreadcrumbs
{
    public $tagName = 'ol';
    public $homeLink = false;
    public $htmlOptions = array('class' => 'breadcrumb');
    public $activeLinkTemplate = '<li><a href="{url}">{label}</a></li>';
    public $inactiveLinkTemplate = '<li class="active">{label}</li>';
    public $separator = '';
}