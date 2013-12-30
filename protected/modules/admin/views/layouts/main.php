<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>后台管理</title>
	<?php 
	    /*注册Js和Css*/
	    Yii::app()->clientScript->registerCssFile($this->admin_assets."/css/bootstrap.min.css")
                                ->registerCssFile($this->admin_assets."/css/admin.css")
	                            ->registerCoreScript('jquery')
	                            ->registerScriptFile($this->admin_assets."/js/libs/bootstrap.min.js", CClientScript::POS_END)
                                ->registerScriptFile($this->admin_assets."/js/admin.js", CClientScript::POS_END);

         // JS变量
        Yii::app()->clientScript->registerScript('js_variables','
                var admin_root = "'.$this->createUrl("/admin").'";
        ',CClientScript::POS_HEAD);
	?>
</head>

<body>
<div class="container">
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
                <a class="navbar-brand" href="<?=$this->createUrl('/admin/default/dashboard')?>">后台管理</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'nav navbar-nav'),
                    'encodeLabel' => false,
                    'items'=>array(
                        array('label'=>'首页', 'url'=>array('/social') ),
                        array('label'=>'Rss管理', 'url'=>array('/admin/rss'), 'active'=>$this->uniqueID=='admin/rss' ? true : false ),
                    ),
                )); ?>    

                <?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'nav navbar-nav navbar-right'),
                    'encodeLabel' => false,
                    'items'=>array(
                        array('label'=>'登出'.' ('.Yii::app()->user->getState('username').')', 'url'=>array('logout'), 'visible'=>!Yii::app()->user->isGuest)
                    ),
                )); ?>    
            </div>
        </nav>
	</header>
    
	<?php echo $content; ?>
</div>
</body>
</html>
