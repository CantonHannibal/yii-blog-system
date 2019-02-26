<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ClbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clbums';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clbum-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Clbum', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'teacher_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
