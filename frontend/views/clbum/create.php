<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Clbum */

$this->title = 'Create Clbum';
$this->params['breadcrumbs'][] = ['label' => 'Clbums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clbum-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
