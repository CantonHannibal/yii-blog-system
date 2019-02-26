<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Teach */

$this->title = 'Create Teach';
$this->params['breadcrumbs'][] = ['label' => 'Teaches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teach-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
