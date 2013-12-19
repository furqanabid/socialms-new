<?php
/**
 * xzController is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class xzController extends CController
{
	public $layout='//layouts/column1';

	public $menu=array();
	public $breadcrumbs=array();

    // 静态image文件
    public $assets_img;

    /**
     * controller的初始化
     * @return [type] [description]
     */
    public function init()
    {
        $this->assets_img = Yii::app()->assetManager->publish(
            Yii::getPathOfAlias('webroot.themes.default.images'),
            false,
            -1,
            defined('YII_DEBUG') && YII_DEBUG
        );

        // 导入Api常量文件
        Yii::import('application.components.api.api_constants',true);
    }
}
?>