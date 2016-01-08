<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BowerAsset extends AssetBundle
{

    public $sourcePath = '@bower';
    public $css = [
        'magnific-popup/dist/magnific-popup.css',
    ];
    public $js = [
        'magnific-popup/dist/jquery.magnific-popup.min.js',
        'holderjs/holder.min.js'
    ];
    public $depends = [

    ];
}