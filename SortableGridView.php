<?php

namespace twixoff\sortablegrid;

use yii\helpers\Url;
use yii\grid\GridView;

class SortableGridView extends GridView
{
    /** @var string|array Sort action */
    public $sortableAction = ['sort'];
    
    /** @var bool Sort column show */
    public $sortableColumn = false;

    public function init()
    {
        if($this->sortableColumn) {
            array_unshift($this->columns, ['class' => 'twixoff\sortablegrid\SortableColumn']);
        }
        $this->sortableAction = Url::to($this->sortableAction);
        parent::init();
    }

    public function run()
    {
        $this->registerWidget();
        parent::run();
    }

    protected function registerWidget()
    {
        $view = $this->getView();
        $view->registerJs("jQuery('#{$this->options['id']}').SortableGridView('{$this->sortableAction}');");
        SortableGridAsset::register($view);
    }
}
