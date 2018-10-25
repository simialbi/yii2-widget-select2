<?php
/**
 * @package yii2-widget-select2
 * @author Simon Karlen <simi.albi@gmail.com>
 */

namespace simialbi\yii2\select2;

use simialbi\yii2\web\AssetBundle;

/**
 * Asset bundle for [[Select2]] Widget.
 *
 * @author Simon Karlen <simi.albi@gmail.com>
 * @since 1.0
 */
class Select2Asset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     */
    public $sourcePath = '@bower/select2/dist';

    /**
     * @var array list of CSS files that this bundle contains.
     */
    public $css = [
        'css/select2.min.css'
    ];

    /**
     * @var array list of JavaScript files that this bundle contains.
     */
    public $js = [
        'js/select2.full.min.js'
    ];

    /**
     * @var array list of bundle class names that this bundle depends on.
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    /**
     * @var array the options to be passed to [[AssetManager::publish()]] when the asset bundle
     * is being published.
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG
    ];
}