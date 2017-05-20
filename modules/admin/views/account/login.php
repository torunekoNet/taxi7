<?php
/**
 * file:login.php
 * author:Toruneko@outlook.com
 * date:2014-7-12
 * desc: 登录页面
 */
$this->cs->registerPackage('bootstrap');
$this->cs->registerPackage('admin');
?>
<div class="container">
    <div class="row">
        <div class="col-xs-10 col-sm-8 col-md-4 col-xs-offset-1 col-sm-offset-2 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo CHtml::encode($this->getPageTitle()); ?></div>
                <div class="panel-body">
                    <?php $form = $this->beginWidget('CActiveForm', array(
                        'htmlOptions' => array(
                            'class' => 'form-horizontal'
                        ),
                    )); ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'username', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
                        <div class="col-xs-9 col-sm-9 col-md-9">
                            <?php echo $form->textField($model, 'username', array('class' => 'form-control')) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'password', array('class' => 'col-xs-3 col-sm-3 col-md-3 control-label')); ?>
                        <div class="col-xs-9 col-sm-9 col-md-9">
                            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-xs-4 col-sm-4 col-md-4">
                            <div class="checkbox">
                                <label>
                                    <?php echo $form->checkBox($model, 'remember'); ?>记住我
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-xs-2 col-sm-2 col-md-2">
                            <?php echo CHtml::submitButton('进入', array('class' => 'btn btn-default')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div class="panel-footer">
                    <?php echo $form->error($model, 'username'); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
