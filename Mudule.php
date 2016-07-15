<?php

namespace mickey\news;
use yii\base\Module as BaseModule;

/**
 * news module definition class
 */
class Mudule extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'mickey\news\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
