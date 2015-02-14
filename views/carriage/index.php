<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Carriage;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarriageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carriages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carriage-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Carriage', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'carriage_type',
            'brutto_weight',
            [
                'label' => 'status',
                'format' => 'text',
                'value' => function(Carriage $model) { return \app\models\CarriageStatus::getLabelByStatusId($model->status);}
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
