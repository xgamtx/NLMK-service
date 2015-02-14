<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WheelSetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wheel Sets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wheel-set-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Wheel Set', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'produced_year',
            'factory',
            'right_wheel_width',
            'left_wheel_width',
            // 'real_produced_year',
            // 'real_factory',
            // 'carriage_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
