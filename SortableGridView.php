<?php
/**
 * @link https://github.com/himiklab/yii2-sortable-grid-view-widget
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT
 */

namespace himiklab\sortablegrid;

use yii\grid\GridView;
use yii\helpers\Url;

/**
 * Sortable version of Yii2 GridView widget.
 *
 * @author HimikLab
 * @package himiklab\sortablegrid
 */
class SortableGridView extends GridView
{
    /** @var string  Name of the action to call and sort values */
    public $sortableAction = 'sort';

    public function init()
    {
        parent::init();
        $this->processRowOptions();
    }

    public function run()
    {
        $this->registerWidget();
        parent::run();
    }

    protected function registerWidget()
    {
        $view = $this->getView();
        $url = Url::toRoute([ $view->context->id . '/' . $this->sortableAction]);

        $view->registerJs(
            "$.fn.SortableGridView('{$this->id}', '{$url}');"
        );
        SortableGridAsset::register($view);
    }

    protected function processRowOptions()
    {
        $rowOptions = $this->rowOptions;
        $this->rowOptions = function ($model, $key, $index, $grid) use ($rowOptions) {
            if (!empty($rowOptions)) {
                if ($rowOptions instanceof \Closure) {
                    $rowOptions = call_user_func($rowOptions, $model, $key, $index, $grid);
                }
                if (isset($rowOptions['class'])) {
                    return array_merge($rowOptions, ['class' => "items[]_{$model->id} {$rowOptions['class']}"]);
                }
                return array_merge($rowOptions, ['class' => "items[]_{$model->id}"]);
            }
            return ['class' => "items[]_{$model->id}"];
        };
    }
}
