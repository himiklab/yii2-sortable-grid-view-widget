<?php

namespace twixoff\sortablegrid;

use yii\grid\Column;

class SortableColumn extends Column
{
    public $header = "<span class='glyphicon glyphicon-menu-hamburger'></span>";
    
    public $headerOptions = [
        'class' => 'text-center',
        'style' => 'width: 30px;'
    ];
    
    public $contentOptions = [
        'class' => 'sort-handle text-center',
        'style' => 'cursor: move;'
    ];


    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content !== null) {
            return call_user_func($this->content, $model, $key, $index, $this);
        } else {
            return "<span class='glyphicon glyphicon-menu-hamburger'></span>";
        }
    }
}
