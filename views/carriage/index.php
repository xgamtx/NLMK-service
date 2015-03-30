<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Carriage;
use app\models\Warehouse;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarriageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusList string[] */

$this->title = 'Вагоны';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carriage-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel, 'statusList' => $statusList]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => '\yii\grid\CheckboxColumn',
            ],
            [
                'label' =>'id',
                'format' => 'html',
                'attribute' => 'id',
                'value' => function(Carriage $model) { return "<a href='/web/carriage/view?id={$model->id}'>{$model->id}</a>";},
            ],
            'carriage_type',
            [
                'label' => 'ПЗУ',
                'format' => 'raw',
                'attribute' =>'storage',
                'value' => function(Carriage $model) {
                    return !empty($model->storage) ? Warehouse::getNameById($model->storage) : '-';
                },
            ],
            [
                'label' =>'Тара',
                'format' => 'raw',
                'attribute' =>'brutto_weight',
                'value' => function(Carriage $model) {
                    if (!empty($model->brutto_weight)) {
                        return $model->brutto_weight;
                    } else {
                        return $this->render('_setValueForm', [
                            'model' => $model,
                            'propertyName' => 'brutto_weight',
                            'propertyLabel' => 'Тара',
                            'url' => 'carriage/save-weight',
                        ]);
                    }
                },
            ],
            [
                'label' =>'Детали',
                'attribute' =>'netto_mass',
                'value' => function(Carriage $model) { return $model->getWeight(); },
            ],
            [
                'label' =>'Лом',
                'attribute' => 'scrap_metal',
                'value' => function(Carriage $model) { return $model->brutto_weight - $model->getWeight(); },
            ],
            [
                'label' => 'Статус',
                'attribute' => 'status',
                'format' => 'text',
                'value' => function(Carriage $model) { return \app\models\CarriageStatus::getLabelByStatusId($model->status);}
            ],
            [
                'label' => 'Склад',
                'value' => function(Carriage $model) { return empty($model->warehouse) ? '-' : Warehouse::getNameById($model->warehouse->name); }
            ],
            [
                'label' => 'Время прибытия',
                'value' => function(Carriage $model) {
                    return $model->datetime_arrived == '0000-00-00 00:00:00' ? '' : $model->datetime_arrived;
                }
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
