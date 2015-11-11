<?php

namespace himiklab/sortablegrid;

use yii\grid\Column;

class SortableColumn extends Column
{
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
    protected function renderHeaderCellContent()
    {
        return "<span class='glyphicon glyphicon-menu-hamburger'></span>";
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return "<span class='glyphicon glyphicon-menu-hamburger'></span>";
    }
}
