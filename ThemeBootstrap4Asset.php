<?php
/**
 * @package yii2-widget-select2
 * @author Simon Karlen <simi.albi@gmail.com>
 */

namespace simialbi\yii2\select2;

use simialbi\yii2\web\AssetBundle;

/**
 * Asset bundle for the bootstrap 4 theme for [[Select2]] Widget.
 *
 * @author Simon Karlen <simi.albi@gmail.com>
 * @since 1.0
 */
class ThemeBootstrap4Asset extends AssetBundle {
	/**
	 * @var string the directory that contains the source asset files for this asset bundle.
	 */
	public $sourcePath = '@bower/select2-bootstrap4-theme/dist';

	/**
	 * @var array list of CSS files that this bundle contains.
	 */
	public $css = [
		'css/select2-bootstrap4.min.css'
	];

	/**
	 * @var array list of bundle class names that this bundle depends on.
	 */
	public $depends = [
		'simialbi\yii2\select2\Select2Asset',
		'yii\bootstrap4\BootstrapAsset'
	];
}