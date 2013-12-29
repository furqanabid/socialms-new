<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		// 定义admin module的layout文件
		$this->layoutPath = Yii::getPathOfAlias('admin.views.layouts');
		$this->layout = 'main';

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
