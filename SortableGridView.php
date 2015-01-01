<?php
/**
 * @link https://github.com/himiklab/yii2-sortable-grid-view-widget
 * @copyright Copyright (c) 2014 HimikLab
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
    /** @var string  Name of the action to call and sort values */
    public $sortableAction = 'sort';

    public function init()
    {
        parent::init();
        $this->sortableAction = Url::to([$this->sortableAction]);
    }

    public function run()
    {
        $this->registerWidget();
        parent::run();
    }

    protected function registerWidget()
    {
        $view = $this->getView();
        $view->registerJs("jQuery('#{$this->id}').SortableGridView('{$this->sortableAction}');");
        SortableGridAsset::register($view);
    }
}
