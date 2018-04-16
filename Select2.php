<?php
/**
 * @package yii2-widget-select2
 * @author Simon Karlen <simi.albi@gmail.com>
 */

namespace simialbi\yii2\select2;

use simialbi\yii2\widgets\InputWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;


/**
 * Select2 widget is a Yii2 wrapper for the Select2 jQuery plugin. This input widget is a jQuery based replacement for
 * select boxes. It supports searching, remote data sets, and infinite scrolling of results.
 *
 * * For example to use Select2 with a [[\yii\base\Model|model]]:
 *
 * ```php
 * echo Select2::widget([
 *     'model' => $model,
 *     'attribute' => 'my_select',
 *     'data' => ['key' => 'value', 'foo' => 'bar']
 * ]);
 * ```
 *
 * The following example will use the name property instead:
 *
 * ```php
 * echo Select2::widget([
 *     'name'  => 'my_select',
 *     'value'  => $value,
 *     'data' => ['key' => 'value', 'foo' => 'bar']
 * ]);
 * ```
 *
 * You can also use this widget in an [[\yii\widgets\ActiveForm|ActiveForm]] using the
 * [[\yii\widgets\ActiveField::widget()|widget()]] method, for example like this:
 *
 * ```php
 * <?= $form->field($model, 'my_select')->widget(\simialbi\yii2\select2\Select2::class, [
 *     'data' => ['key' => 'value', 'foo' => 'bar']
 * ]) ?>
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Simon Karlen <simi.albi@gmail.com>
 * @since 1.0
 * @see https://github.com/select2/select2
 */
class Select2 extends InputWidget {
	/**
	 * Select2 default theme
	 */
	const THEME_DEFAULT = 'default';
	/**
	 * Select2 classic theme
	 */
	const THEME_CLASSIC = 'classic';
	/**
	 * Select2 Bootstrap theme
	 */
	const THEME_BOOTSTRAP = 'bootstrap4';

	/**
	 * @var array $data the option data items. The array keys are option values, and the array values are the
	 * corresponding option labels. The array can also be nested (i.e. some array values are arrays too). For each
	 * sub-array, an option group will be generated whose label is the key associated with the sub-array. If you
	 * have a list of data models, you may convert them into the format described above using [[ArrayHelper::map()]].
	 */
	public $data;
	/**
	 * @var string the theme name to be used for styling the Select2.
	 */
	public $theme = self::THEME_DEFAULT;
	/**
	 * @var boolean whether input is to be disabled
	 */
	public $disabled = false;
	/**
	 * @var string|array, the displayed text in the dropdown for the initial value when you do not set or provide
	 * `data` (e.g. using with ajax). If options['multiple'] is set to `true`, you can set this as an array of text
	 * descriptions for each item in the dropdown `value`.
	 */
	public $initValueText;
	/**
	 * @var boolean whether to hide the search control and render it as a simple select.
	 */
	public $hideSearch = false;

	/**
	 * {@inheritdoc}
	 */
	public function run() {
		parent::run();
		return $this->renderWidget();
	}

	/**
	 * Initializes and renders the widget
	 */
	public function renderWidget() {
		$this->clientOptions['theme'] = $this->theme;
		$multiple                     = ArrayHelper::remove($this->clientOptions, 'multiple', false);
		$multiple                     = ArrayHelper::getValue($this->options, 'multiple', $multiple);
		$this->options['multiple']    = $multiple;
		if (empty($this->clientOptions['width'])) {
			$this->clientOptions['width'] = '100%';
		}
		if ($this->hideSearch) {
			$this->clientOptions['minimumResultsForSearch'] = new JsExpression('Infinity');
		}
		if ($this->disabled) {
			$this->clientOptions['disabled'] = true;
		}
		if (isset($this->options['placeholder'])) {
			$this->clientOptions['placeholder'] = ArrayHelper::remove($this->options, 'placeholder');
			ArrayHelper::setValue($this->options, 'data.placeholder', $this->clientOptions['placeholder']);
		}
		if (!isset($this->data)) {
			if (!isset($this->value) && !isset($this->initValueText)) {
				$this->data = [];
			} else {
				if ($multiple) {
					$key = isset($this->value) && is_array($this->value) ? $this->value : [];
				} else {
					$key = isset($this->value) ? $this->value : '';
				}
				$val        = isset($this->initValueText) ? $this->initValueText : $key;
				$this->data = $multiple ? array_combine((array)$key, (array)$val) : [$key => $val];
			}
		}
		Html::addCssClass($this->options, 'form-control');
		$html = $this->renderInput();
		$this->registerPlugin('select2');

		if ($this->theme === self::THEME_BOOTSTRAP) {
			ThemeBootstrap4Asset::register($this->view);
		}

		return $html;
	}

	/**
	 * Renders the source Input for the Select2 plugin. Graceful fallback to a normal HTML select dropdown or text
	 * input - in case JQuery is not supported by the browser
	 */
	protected function renderInput() {
		$options = $this->options;

		if ($this->hasModel()) {
			$input = Html::activeDropDownList($this->model, $this->attribute, $this->data, $options);
		} else {
			$input = Html::dropDownList($this->name, $this->value, $this->data, $options);
		}

		return $input;
	}
}