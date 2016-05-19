<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
	public $sourcePath ='@bower/flatlab/';
    public $css = [
        'css/bootstrap.min.css',
		'css/bootstrap-reset.css',
		'assets/font-awesome/css/font-awesome.css',
		'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
		'css/owl.carousel.css',
		'css/slidebars.css',
		'css/style.css',
		'css/style-responsive.css',
		
    ];
    public $js = [
		'js/jquery.js',
		'js/bootstrap.min.js',
		'js/jquery.dcjqaccordion.2.7.js',
		'js/jquery.scrollTo.min.js',
		'js/jquery.nicescroll.js',
		'js/jquery.sparkline.js',
		'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js',
		'js/owl.carousel.js',
		'js/jquery.customSelect.min.js',
		'js/respond.min.js',
		'js/slidebars.min.js',
		'js/common-scripts.js',
		'js/sparkline-chart.js',
		'js/easy-pie-chart.js',
		'js/count.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
