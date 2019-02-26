<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/3
 * Time: 8:50
 */
$this->title = "创建";
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['post/index']];
$this->params['breadcrumbs'][] = $this->title;
//echo 11111;
?>

<div class="row">
    <div class="col-lg-9">
        <div class="panel-title box-title">
            <span>创建文章</span>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
        <!--标题-->
            <?= $form->field($model, 'title')->textinput(['maxlength' => true]) ?>
        <!--分类-->
            <?= $form->field($model, 'cat_id')->dropDownList($cat) ?>
        <!--正文-->
        <!--//$form->field($model, 'content')->textinput(['maxlength' => true]) ?>-->
            <?= $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor', [
                'options' => [
//                    'initialFrameWidth' => 850,
                    'initialFrameHeight' => 400,
//                    'toolbars'=>[],//这里按需要添加富文本编辑器的工具，为空的话，全部工具都消失
                ]
            ]) ?>
        <!--标签-->
        <!--//$form->field($model, 'tags')->textinput(['maxlength' => true]) -->
            <?= $form->field($model, 'tags')->widget('common\widgets\tags\TagWidget')?>
        <!--标签缩略图-->
        <!-- //$form->field($model, 'label_img')->textinput(['maxlength' => true]) ?>-->
            <?= $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload', [
                'config' => [
                    //'domain_url' => 'http://www.yii-china.com',
                ]
            ]) ?>


            <div class="form-group">
                <?= Html::submitButton("发布", ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel-title box-title">
            <span>注意事项</span>

        </div>
    </div>
</div>
