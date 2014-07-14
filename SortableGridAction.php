<?php
/**
 * @link https://github.com/himiklab/yii2-sortable-grid-view-widget
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT
 */

namespace himiklab\sortablegrid;

use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;

/**
 * Action for sortable Yii2 GridView widget.
 *
 * For example:
 *
 * ```php
 * public function actions()
 * {
 *    return [
 *       'sort' => [
 *          'class' => SortableGridAction::className(),
 *          'modelName' => Model::className(),
 *       ],
 *   ];
 * }
 * ```
 *
 * @author HimikLab
 * @package himiklab\sortablegrid
 */
class SortableGridAction extends Action
{
    public $modelName;

    public function run()
    {
        if (!isset($_POST['items']) || !is_array($_POST['items'])) {
            throw new BadRequestHttpException();
        }

        /** @var \yii\db\ActiveRecord $model */
        $model = new $this->modelName;
        if (!$model->hasMethod('gridSort', true)) {
            throw new InvalidConfigException("Not found right SortableGridBehavior in {$this->modelName}.");
        }

        $model->gridSort($_POST['items']);
    }
}
