<?php

use app\models\DateConverter;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Carriage;
use app\models\Warehouse;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarriageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusList string[] */
/* @var $storageList string[] */

$this->title = 'Вагоны';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carriage-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel, 'statusList' => $statusList, 'storageList' => $storageList]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'carriage-index',
//        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => '\yii\grid\CheckboxColumn',
            ],
            [
                'label' => 'Статус',
                'attribute' => 'status',
                'format' => 'text',
                'value' => function(Carriage $model) { return \app\models\CarriageStatus::getLabelByStatusId($model->status);}
            ],
            [
                'label' =>'Номер вагона',
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
                'label' => 'Склад',
                'format' => 'raw',
                'attribute' =>'warehouse_id',
                'value' => function(Carriage $model) {
                    return !empty($model->warehouse_id) ? Warehouse::getNameById($model->warehouse_id) : '-';
                },
            ],
            [
                'label' => 'Дата прибытия',
                'attribute' => 'datetime_arrived',
                'value' => function(Carriage $model) {
                    if ($model->arrive_date == '0000-00-00 00:00:00') {
                        return '';
                    } else {
                        return DateConverter::convertToReadable($model->arrive_date);
                    }
                }
            ],
            [
                'label' =>'Расчетная масса лома',
                'value' => function(Carriage $model) {
                    return $model->getCalculateWasteWeight();
                },
            ],
            [
                'label' =>'Масса лома на складе',
                'value' => function(Carriage $model) { return $model->getWeight(); },
            ],
            [
                'label' =>'Недосдача лома',
                'value' => function(Carriage $model) { return $model->getCalculateWasteWeight() - $model->getWeight(); },
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
