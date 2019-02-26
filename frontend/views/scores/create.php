<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Scores */

$this->title = 'Create Scores';
$this->params['breadcrumbs'][] = ['label' => 'Scores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
