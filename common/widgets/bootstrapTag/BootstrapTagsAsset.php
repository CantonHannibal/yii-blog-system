<?php

namespace common\widgets\bootstrapTag;

use yii\web\AssetBundle;

class BootstrapTagsAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-tags';
    
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        parent::init();

        $this->js = [
            'dist/js/bootstrap-tags'.(YII_DEBUG ? '.js' : '.min.js'),
        ];

        $this->css = [
            'dist/css/bootstrap-tags.css',
        ];    
    }
}
