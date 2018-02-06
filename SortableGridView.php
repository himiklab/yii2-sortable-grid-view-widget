<?php
/**
 * @link https://github.com/himiklab/yii2-sortable-grid-view-widget
 * @copyright Copyright (c) 2014-2017 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace himiklab\sortablegrid;

use yii\helpers\Url;
use yii\grid\GridView;

/**
 * Sortable version of Yii2 GridView widget.
 *
 * @author HimikLab
 * @package himiklab\sortablegrid
 */
class SortableGridView extends GridView
{
    /** @var string|array Sort action */
    public $sortableAction = ['sort'];
    /** @var string Model class name */
    public $modelClass;

    public function init()
    {
        parent::init();
        $this->sortableAction = Url::to($this->sortableAction);
    }

    public function run()
    {
        $this->registerWidget();
        parent::run();
    }

    protected function registerWidget()
    {
        $view = $this->getView();
        $class = str_replace('\\', '\\\\', $this->modelClass);
        $view->registerJs("jQuery('#{$this->options['id']}').SortableGridView('{$this->sortableAction}',
                                                                              '{$class}');");
        SortableGridAsset::register($view);
    }
}
