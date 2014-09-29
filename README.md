Sortable GridView Widget for Yii2
========================

Sortable modification of Yii2 GridView widget.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "himiklab/yii2-sortable-grid-view-widget" "*"
```
or add

```json
"himiklab/yii2-sortable-grid-view-widget" : "*"
```

to the require section of your application's `composer.json` file.

Usage
-----
* Add in the AR model new uint attribute, such `sortOrder`.

* Add action in the controller:

```php
use himiklab\sortablegrid\SortableGridAction;

public function actions()
{
    return [
        'sort' => [
            'class' => SortableGridAction::className(),
            'modelName' => Model::className(),
        ],
    ];
}
```

* Add behavior in the AR model:

```php
use himiklab\sortablegrid\SortableGridBehavior;

public function behaviors()
{
    return [
        'sort' => [
            'class' => SortableGridBehavior::className(),
            'sortableAttribute' => 'sortOrder'
        ],
    ];
}
```

* Use SortableGridView as standard GridView with `sortableAction` option.
