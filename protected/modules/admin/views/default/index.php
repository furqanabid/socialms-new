<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="<?=$this->admin_assets?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$this->admin_assets?>/css/login.css">

    <title>
        管理员登录
    </title>
</head>

<body>

<div class="container login-form"> 
    <div class="row">
        <div class="col-md-6 col-md-offset-3 login-div">
        	<h3 class="text-center">管理员登录</h3>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'htmlOptions' => array(
                        'class' => 'form-horizontal',
                        'role' => 'form'
                ),
            )); ?>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'email', array('class'=>'col-sm-3 control-label')); ?>
                <div class="col-sm-8">
                    <?php echo $form->textField($model, 'email', array('class'=>'form-control')); ?>
                    <?php echo $form->error($model,'email'); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'password', array('class'=>'col-sm-3 control-label')); ?>
                <div class="col-sm-8">
                    <?php echo $form->passwordField($model, 'password', array('class'=>'form-control')); ?>
                    <?php echo $form->error($model,'password'); ?>
                </div>
            </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model,'rememberMe'); ?>
                                <?php echo $form->label($model,'rememberMe'); ?>
                                <?php echo $form->error($model,'rememberMe'); ?>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <input type="submit" value="登录" class="btn btn-primary">
                        <a type="button" href="<?=$this->createUrl('register');?>" class="btn btn-primary">注册</a>
                    </div>
                </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<footer id="footer" class="text-center">
    <?php echo Yii::powered(); ?>
</footer>

</body>
</html>