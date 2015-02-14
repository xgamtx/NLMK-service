<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Carriage;
use yii\bootstrap\Button;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarriageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carriages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carriage-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><a href="#modal" role="button" class="btn btn-primary" data-toggle="modal">Загрузить</a></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' =>'id',
                'format' => 'html',
                'value' => function(Carriage $model) { return "<a href='/web/carriage/view?id={$model->id}'>{$model->id}</a>";},
            ],
            'carriage_type',
            'storage',
            'brutto_weight',
            [
                'label' =>'Детали',
                'value' => function(Carriage $model) { return $model->getWeight(); },
            ],
            [
                'label' =>'Лом',
                'value' => function(Carriage $model) { return $model->brutto_weight - $model->getWeight(); },
            ],
            [
                'label' => 'Статус',
                'format' => 'text',
                'value' => function(Carriage $model) { return \app\models\CarriageStatus::getLabelByStatusId($model->status);}
            ],
            [
                'label' => 'Склад',
                'value' => function(Carriage $model) { return empty($model->warehouse) ? '-' : $model->warehouse->name; }
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <div id="modal" class="modal">
        <div class="modal-dialog" style="background: #fff">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2>Выберите файл для загрузки</h2>
            </div>
            <div class="modal-body">
                <label>Документ xls:<input type="file"></label>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('document').ready(function(){
            $('#modal').modal('false');
        });
    </script>


</div>
