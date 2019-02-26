<?php

namespace common\widgets\bootstrapTag;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Yii2 widget-wrapper for [bootstrap-tags](https://github.com/maxwells/bootstrap-tags) bootstrap widget
 * with one enhencemets: it renders and updates hidden input with tags (in string separated by [[separator]])
 * so it can be sent with form
 *
 * It uses [[separator]] to separate tags in hidden input and also for adding
 * multiple tags simultaneously when user type several values separated by
 * [[separator]] and hits enter
 *
 * As any InputWidget can use ( [[model]] and [[attribute]] ) or ( [[name]] and [[value]] )
 */
class BootstrapTags extends \yii\widgets\InputWidget
{
    /** @var boolean Use or not hidden input for tags values */
    public $useHiddenInput = true;
    /**
     * Config that will be given to bootstrap widget, lookfor possible options in
     * [bootstrap widget documentation](https://github.com/maxwells/bootstrap-tags#settings)
     * @var array
     */
    public $jsConfig = [];

    /** @var string Separator that will be used to separate tags in hidden input */
    public $separator = ',';

    public function init()
    {
        parent::init();

        if(!$this->getId(false) and $this->hasModel()) {
            $this->id = $this->options['id'];
        }

        $this->options['class'] = isset($this->options['class'])
            ? $this->options['class'] . ' bootstrap-tags'
            : 'bootstrap-tags'
        ;
    }

    public function run()
    {
        echo Html::beginTag('div', $this->options);

        if($this->useHiddenInput) {
            if($this->hasModel())
                echo Html::activeHiddenInput($this->model, $this->attribute);
            else
                echo Html::hiddenInput($this->name, $this->value);
        }

        echo Html::endTag('div');

        $this->registerAssets();
    }

    protected function registerAssets()
    {
        BootstrapTagsAsset::register($this->getView());       

        $this->view->registerJs("
            var tagsContainerSelector = '#{$this->id}';
            var separator = '{$this->separator}';
            var options = {$this->getClientOptions()};
        ");

        $this->view->registerJs('
            var $tagsContainer = $(tagsContainerSelector);
            var $inputWithValue = $tagsContainer.find("input[type=hidden]");

            function updateTagsInput() {
                $inputWithValue.val($tags.getTags().join(separator));
            }

            var $tags = $tagsContainer.tags(options);
        ');
    }

    protected function getSeparatorRegex()
    {
        return "\s*{$this->separator}\s*";
    }

    protected function getClientOptions()
    {
        $tags = [];
        $value = $this->hasModel() ? $this->model->{$this->attribute} : $this->value;

        if(is_array($value)) {
            $tags = $value;
        } elseif(is_string($value)) {
            $tags = preg_split("/{$this->separatorRegex}/", $value);
        }
        
        $config = [
            'tagData' => $tags,
        ];

        if($this->useHiddenInput) {
            $userBeforeAddingTag = isset($this->jsConfig['beforeAddingTag'])
                ? $this->jsConfig['beforeAddingTag']
                : 'function(tagname) { return true; }'
            ;
            unset($this->jsConfig['beforeAddingTag']);

            $userAfterAddingTag = isset($this->jsConfig['afterAddingTag'])
                ? $this->jsConfig['afterAddingTag']
                :   'function(tagName){}';
            ;
            unset($this->jsConfig['afterAddingTag']);

            $userAfterDeletingTag = isset($this->jsConfig['afterDeletingTag'])
                ? $this->jsConfig['afterDeletingTag']
                :   'function(tagName){}';
            ;
            unset($this->jsConfig['afterDeletingTag']);

            $config = $config + [
                'beforeAddingTag' => new JsExpression("
                    function(tagName) {
                        if(tagName.match(/{$this->separatorRegex}/)) {
                            separatedTags = tagName.split(/{$this->separatorRegex}/);
                            for(i in separatedTags) {
                                \$tags.addTag(separatedTags[i]);
                            }
                            return false;
                        } else {
                            return ({$userBeforeAddingTag})(tagName);
                        }
                    }
                "),
                'afterAddingTag' => new JsExpression("
                    function(tagName) {
                        updateTagsInput();
                        ({$userAfterAddingTag})(tagName);
                    }
                "),
                'afterDeletingTag' => new JsExpression("
                    function(tagName) {
                        updateTagsInput();
                        ({$userAfterDeletingTag})(tagName);
                    }
                "),
            ];
        }

        return Json::encode(ArrayHelper::merge($config, $this->jsConfig));
    }
    
}