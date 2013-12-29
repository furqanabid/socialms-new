<?php
/**
 * xz1Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class xz1Controller extends CController
{
	public $menu=array();
	public $breadcrumbs=array();

    public $admin_assets;

    /**
     * controller的初始化
     * @return [type] [description]
     */
    public function init()
    {
    	$this->admin_assets = Yii::app()->assetManager->publish(
            Yii::getPathOfAlias('admin.assets'),
            false,
            -1,
            defined('YII_DEBUG') && YII_DEBUG
        );
    }

}
?>