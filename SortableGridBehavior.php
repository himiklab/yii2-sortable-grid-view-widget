<?php
/**
 * @link https://github.com/himiklab/yii2-sortable-grid-view-widget
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace himiklab\sortablegrid;

use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * Behavior for sortable Yii2 GridView widget.
 *
 * For example:
 *
 * ```php
 * public function behaviors()
 * {
 *    return [
 *       'sort' => [
 *           'class' => SortableGridBehavior::className(),
 *           'sortableAttribute' => 'sortOrder',
 *           'scopeAttribute' => null
 *       ],
 *   ];
 * }
 * ```
 *
 * @author HimikLab
 * @package himiklab\sortablegrid
 */
class SortableGridBehavior extends Behavior
{
    /** @var string database field name for row sorting */
    public $sortableAttribute = 'sortOrder';
    
    /** @var string database field name for defining scope */
    public $scopeAttribute = null;

    public function events()
    {
        return [ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert'];
    }

    public function gridSort($items)
    {
        /** @var ActiveRecord $model */
        $model = $this->owner;
        if (!$model->hasAttribute($this->sortableAttribute)) {
            throw new InvalidConfigException("Model does not have sortable attribute `{$this->sortableAttribute}`.");
        }

        $newOrder = [];
        $models = [];
        foreach ($items as $old => $new) {
            $models[$new] = $model::findOne($new);
            $newOrder[$old] = $models[$new]->{$this->sortableAttribute};
        }
        $model::getDb()->transaction(function () use ($models, $newOrder) {
            foreach ($newOrder as $modelId => $orderValue) {
                /** @var ActiveRecord[] $models */
                $models[$modelId]->updateAttributes([$this->sortableAttribute => $orderValue]);
            }
        });
    }

    public function beforeInsert()
    {
        /** @var ActiveRecord $model */
        $model = $this->owner;
        if (!$model->hasAttribute($this->sortableAttribute)) {
            throw new InvalidConfigException("Invalid sortable attribute `{$this->sortableAttribute}`.");
        }

        if ($this->scopeAttribute !== null &&
            !$model->hasAttribute($this->scopeAttribute)) {
            throw new InvalidConfigException("Invalid scope attribute `{$this->scopeAttribute}`.");
        }
        
        if ($this->scopeAttribute !== null)
        {
            $maxOrder = $model->find()->where([$this->scopeAttribute => $model->{$this->scopeAttribute}])->max($model->tableName() . '.' . $this->sortableAttribute);
        }
        else
        {
            $maxOrder = $model->find()->max($model->tableName() . '.' . $this->sortableAttribute);
        }
        $model->{$this->sortableAttribute} = $maxOrder + 1;
    }
}
