<?php

use app\models\Warehouse;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\CarriageStatus;
use app\models\Carriage;
use app\models\UploadImage;

/* @var $this yii\web\View */
/* @var $model Carriage */

$this->title = $model->getName();
$this->params['breadcrumbs'][] = ['label' => 'Список вагонов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('//carriage/_navbar', [
    'selectTabId' => 0,
    'model' => $model
]) ?>
<div class="carriage-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Прибыл', ['set-status', 'id' => $model->id, 'new_status' => CarriageStatus::ARRIVED], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Are you sure you want to change status this item?',
//                'method' => 'get',
            ],
        ]) ?>
        <?= Html::a('Корректировка', ['set-status', 'id' => $model->id, 'new_status' => CarriageStatus::CORRECT], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Are you sure you want to change status this item?',
//                'method' => 'get',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Статус',
                'value' => CarriageStatus::getLabelByStatusId($model->status)
            ],
            [
                'label' => 'Комментарий',
                'format' => 'raw',
                'attribute' =>'comment',
                'value' => $this->render('//carriage/_setValueForm', [
                        'model' => $model,
                        'propertyName' => 'comment',
                        'propertyLabel' => 'Комментарий',
                        'url' => 'carriage/update',
                        'size' => '100',
                        'currentValue' => $model->comment
                    ]),
            ],
            [
                'label' => 'Дата прибытия',
                'format' => 'raw',
                'value' => $this->render('//carriage/_setDateValueForm', [
                        'model' => $model,
                        'propertyName' => 'arrive_date',
                        'url' => 'carriage/update',
                        'currentValue' => $model->arrive_date
                    ]),
            ],
            'id',
            [
                'label' => 'Тип вагона',
                'format' => 'raw',
                'attribute' =>'carriage_type',
                'value' => $this->render('//carriage/_setCarriageTypeForm', [
                        'model' => $model,
                        'currentValue' => $model->carriage_type
                    ]),
            ],
            [
                'label' => 'Стоимость ',
                'value' => ''
            ],
            [
                'label' => 'ПЗУ',
                'format' => 'raw',
                'attribute' =>'storage',
                'value' => $this->render('//carriage/_setValueWarehouse', [
                        'model' => $model,
                        'propertyName' => 'storage',
                        'currentValue' => Warehouse::getNameById($model->storage)
                    ]),
            ],
            [
                'label' => 'Склад',
                'format' => 'raw',
                'attribute' =>'warehouse_id',
                'value' => $this->render('//carriage/_setValueWarehouse', [
                        'model' => $model,
                        'propertyName' => 'warehouse_id',
                        'currentValue' => Warehouse::getNameById($model->warehouse_id)
                    ]),
            ],
            [
                'label' => 'Масса тары заявленная',
                'format' => 'raw',
                'attribute' =>'brutto_weight',
                'value' => $this->render('//carriage/_setValueForm', [
                        'model' => $model,
                        'propertyName' => 'brutto_weight',
                        'propertyLabel' => 'Тара',
                        'url' => 'carriage/save-weight',
                        'currentValue' => $model->brutto_weight
                    ]),
            ],
            [
                'label' => 'Масса запчастей расчётная',
                'value' => $model->getWeight()
            ],
            [
                'label' => 'Масса пружин и триангелей',
                'value' => $model->getSpringWeight()
            ],
            [
                'label' => 'Масса тары ЖД весы',
                'format' => 'raw',
                'attribute' =>'weight_z_d',
                'value' => $this->render('//carriage/_setValueForm', [
                        'model' => $model,
                        'propertyName' => 'weight_z_d',
                        'propertyLabel' => 'ЖД весы',
                        'url' => 'carriage/save-weight',
                        'currentValue' => $model->weight_z_d
                    ]),
            ],
            [
                'label' => 'Масса лома Автовесы',
                'format' => 'raw',
                'attribute' =>'weight_auto',
                'value' => $this->render('//carriage/_setValueForm', [
                        'model' => $model,
                        'propertyName' => 'weight_auto',
                        'propertyLabel' => 'автовесы',
                        'url' => 'carriage/update',
                        'currentValue' => $model->weight_auto
                    ]),
            ],
            [
                'label' => 'Масса лома расчётная',
                'value' => $model->getCalculateWasteWeight()
            ],
            [
                'label' => 'Недосдача лома',
                'value' => $model->getCalculateWasteWeight() - $model->getWeight()
            ],
            [
                'label' => 'Письмо на демонтаж',
                'format' => 'raw',
                'value' => !empty($model->destroy_letter) ?
                "<a href='/web/{$model->destroy_letter}' target='_blank'>Просмотр</a>" :
                $this->render('//carriage/_uploadCommonFileForm', [
                    'model' => $model,
                    'url' => 'carriage/save-image',
                    'imageModel' => new UploadImage(),
                    'propertyName' => 'destroy_letter'
                ])
            ],
            [
                'label' => 'Акт выполненных работ',
                'format' => 'raw',
                'value' => !empty($model->act_image) ?
                    "<a href='/web/{$model->act_image}' target='_blank'>Просмотр</a>" :
                    $this->render('//carriage/_uploadCommonFileForm', [
                        'model' => $model,
                        'url' => 'carriage/save-image',
                        'imageModel' => new UploadImage(),
                        'propertyName' => 'act_image'
                    ])
            ],
            [
                'label' => 'Номер акта',
                'format' => 'raw',
                'attribute' =>'act_number',
                'value' => $this->render('//carriage/_setValueForm', [
                        'model' => $model,
                        'propertyName' => 'act_number',
                        'propertyLabel' => 'Номер',
                        'url' => 'carriage/update',
                        'currentValue' => $model->act_number
                    ]),
            ],
            [
                'label' => 'Номер акта выполненных работ',
                'format' => 'raw',
                'attribute' =>'act_number_2',
                'value' => $this->render('//carriage/_setValueForm', [
                        'model' => $model,
                        'propertyName' => 'act_number_2',
                        'propertyLabel' => 'Номер',
                        'url' => 'carriage/update',
                        'currentValue' => $model->act_number_2
                    ]),
            ],
            [
                'label' => 'Дата акта',
                'format' => 'raw',
                'value' => $this->render('//carriage/_setDateValueForm', [
                        'model' => $model,
                        'propertyName' => 'act_date',
                        'url' => 'carriage/update',
                        'currentValue' => $model->act_date,
                    ]),
            ],
            [
                'label' => 'Акт об исключении из общего вагонного парка',
                'format' => 'raw',
                'value' => !empty($model->expulsion_act_image) ?
                    "<a href='/web/{$model->expulsion_act_image}' target='_blank'>Просмотр</a>" :
                    $this->render('//carriage/_uploadCommonFileForm', [
                        'model' => $model,
                        'url' => 'carriage/save-image',
                        'imageModel' => new UploadImage(),
                        'propertyName' => 'expulsion_act_image'
                    ])
            ],
        ],
    ]) ?>
    <div>
        <?= $this->render('//log/_index', [
            'models' => $model->getLogs()->all(),
        ]); ?>
    </div>

</div>
