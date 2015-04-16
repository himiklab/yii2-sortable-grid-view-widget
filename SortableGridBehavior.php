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
 *           'sortableAttribute' => 'sortOrder'
 *           'findMax' => function() {
 *               return self::find()
 *                   ->where(['slider_id' => $this->slider_id])
 *                   ->max('sort_order');
 *           },
 *       ],
 *   ];
 * }
 * ```
 *
 * @author HimikLab
 * @package himiklab\sortablegrid
 *
 * @property ActiveRecord $owner
 */
class SortableGridBehavior extends Behavior
{
    /**
     * @var string database field name for row sorting
     */
    public $sortableAttribute = 'sortOrder';
    /**
     * @var \Closure|array
     */
    public $findMax;

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
        if (!$this->owner->hasAttribute($this->sortableAttribute)) {
            throw new InvalidConfigException("Invalid sortable attribute `{$this->sortableAttribute}`.");
        }
        $this->owner->{$this->sortableAttribute} = $this->findMax() + 1;
    }

    protected function findMax()
    {
        if ($this->findMax instanceof \Closure || is_array($this->findMax)) {
            return call_user_func($this->findMax);
        } else {
            return $this->owner->find()->max($this->sortableAttribute);
        }
    }
}
