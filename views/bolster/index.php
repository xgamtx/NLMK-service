<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Search\BolsterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bolsters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bolster-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bolster', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'produced_year',
            'factory',
            'carriage_id',
            'real_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
