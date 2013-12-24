<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta property="wb:webmaster" content="63f717dc2ac00594" />

    <?php 
        /*注册Js和Css*/
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl."/css/bootstrap.min.css")
                                ->registerCssFile(Yii::app()->theme->baseUrl."/css/main.css")
                                ->registerCoreScript('jquery')
                                ->registerScriptFile(Yii::app()->theme->baseUrl."/js/libs/bootstrap.min.js", CClientScript::POS_END);

        // 下面所有的JS变量都是在social里面使用的
        Yii::app()->clientScript->registerScript('social_variables','
                var root_url = "'.$_SERVER['SCRIPT_NAME'].'";
                var root_img = "'.$this->assets_img.'";
        ',CClientScript::POS_HEAD);
    ?>
	<title>
		<?php echo CHtml::encode($this->pageTitle); ?>
	</title>
</head>

<body>
<div id="page">

	<header id="header">
    	<nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=$this->createUrl('social')?>">社交管理系统</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'nav navbar-nav navbar-right'),
                    'encodeLabel' => false,
                    'items'=>array(
                        array('label'=>'注册', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),     
                        array('label'=>'登出'.' ('.Yii::app()->user->getState('username').')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                    ),
                )); ?>    
            </div>
        </nav>
	</header>
    
	<?php echo $content; ?>
</div>
</body>
</html>
