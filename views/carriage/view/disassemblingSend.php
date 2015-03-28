<?php

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
    'selectTabId' => 3,
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
                'value' => 'Здесь можно писать комментарий'
            ],
            [
                'label' => 'Дата прибытия',
                'value' => ''
            ],
            'id',
            'carriage_type',
            [
                'label' => 'Стоимость ',
                'value' => ''
            ],
            'storage',
            'warehouse',
            [
                'label' => 'Масса тары заявленная',
                'value' => ''
            ],
            [
                'label' => 'Масса запчастей расчётная',
                'value' => ''
            ],
            [
                'label' => 'Масса пружин и триангелей',
                'value' => ''
            ],
            [
                'label' => 'Масса тары ЖД весы',
                'value' => ''
            ],
            [
                'label' => 'Масса лома Автовесы',
                'value' => ''
            ],
            [
                'label' => 'Масса лома расчётная',
                'value' => ''
            ],
            [
                'label' => 'Масса лома на складе',
                'value' => ''
            ],
            [
                'label' => 'Недосдача лома',
                'value' => ''
            ],
            [
                'label' => 'Письмо на демонтаж',
                'value' => ''
            ],
            [
                'label' => 'Акт выполненных работ',
                'value' => ''
            ],
            [
                'label' => 'Номер акта',
                'value' => ''
            ],
            [
                'label' => 'Дата акта',
                'value' => ''
            ],
            [
                'label' => 'Номер акта выполненных работ',
                'value' => ''
            ],
            [
                'label' => 'Акт об исключении из общего вагонного парка',
                'value' => ''
            ],
            [
                'label' =>'Тара',
                'format' => 'raw',
                'attribute' =>'brutto_weight',
                'value' => !empty($model->brutto_weight) ?
                    $model->brutto_weight :
                    $this->render('//carriage/_setValueForm', [
                        'model' => $model,
                        'propertyName' => 'brutto_weight',
                        'propertyLabel' => 'Тара',
                        'url' => 'carriage/save-weight'
                    ]),
            ],[
                'label' => 'Детали',
                'value' => $model->getWeight()
            ],
            [
                'label' => 'Лом',
                'value' => $model->brutto_weight - $model->getWeight()
            ],
        ],
    ]) ?>

    <div><?= !empty($model->im1) ?
        "<a href='/web/{$model->im1}' target='_blank'>Изображение1</a>" :
        $this->render('//carriage/_uploadCommonFileForm', [
            'model' => $model,
            'url' => 'carriage/save-image',
            'imageModel' => new UploadImage(),
            'propertyName' => 'im1'
        ]); ?></div>

    <div><?= !empty($model->im2) ?
        "<a href='/web/{$model->im2}' target='_blank'>Изображение2</a>" :
        $this->render('//carriage/_uploadCommonFileForm', [
            'model' => $model,
            'url' => 'carriage/save-image',
            'imageModel' => new UploadImage(),
            'propertyName' => 'im2'
        ]); ?></div>
    <div>
        <?= $this->render('//log/_index', [
            'models' => $model->getLogs()->all(),
        ]); ?>
    </div>

</div>
