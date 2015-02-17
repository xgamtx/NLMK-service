<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Carriage;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarriageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вагоны';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carriage-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="control-panel">
        <div class="dropdown control-button">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-expanded="true">
                Действия
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Печать</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Сохранить</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Прибыл</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Утвержден на демонтаж</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Демонтирован</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Архив</a></li>
            </ul>
        </div>
        <a href="#modal" role="button" class="btn btn-primary control-button">Склад</a>
        <a href="#modal" role="button" class="btn btn-primary control-button">Архив</a>
        <a href="#modal" role="button" class="btn btn-primary control-button" data-toggle="modal">Добавить</a>
        <div class="gluh"></div>
        <div class="input-group control-input"><input type="text" class="form-control" placeholder="Номер вагона"></div>
        <div class="input-group control-input"><input type="text" class="form-control" placeholder="Тип вагона"></div>
        <div class="input-group control-input"><input type="text" class="form-control" placeholder="ПЗУ"></div>
        <a href="#modal" role="button" class="btn btn-primary control-button">М1</a>
        <a href="#modal" role="button" class="btn btn-primary control-button">М2</a>
        <a href="#modal" role="button" class="btn btn-primary control-button">М3</a>
        <a href="#modal" role="button" class="btn btn-primary control-button">Статус</a>
        <div class="input-group control-input"><input type="text" class="form-control" placeholder="Склад"></div>
        <div class="input-group control-input"><input type="text" class="form-control" placeholder=""></div>
        <span class="defis">-</span>
        <div class="input-group control-input"><input type="text" class="form-control" placeholder=""></div>
        <div class="gluh"></div>
    </div>

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
            <?= $this->render(
                '//xls/_uploadFile',
                array('model' => new \app\models\UploadForm())
            ) ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('document').ready(function(){
            $('#modal').modal('false');
        });
    </script>


</div>
