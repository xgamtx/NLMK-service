<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\CarriageStatus;

/* @var $this yii\web\View */
/* @var $model app\models\Carriage */

$this->title = $model->getName();
$this->params['breadcrumbs'][] = ['label' => 'Список вагонов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
            'id',
            'carriage_type',
            'brutto_weight',
            [
                'label' => 'Детали',
                'value' => $model->getWeight()
            ],
            [
                'label' => 'Лом',
                'value' => $model->brutto_weight - $model->getWeight()
            ],
            [
                'label' => 'status',
                'value' => CarriageStatus::getLabelByStatusId($model->status)
            ],
            'storage'
        ],
    ]) ?>

    <?= $this->render('//wheel-set/_index', [
        'models' => $model->wheelsets,
        'weight' => $model->getWheelsetsWeight()
    ]) ?>

    <?= $this->render('//side-frame/_index', [
        'models' => $model->sideFrames,
        'weight' => $model->getSideFramesWeight()
    ]) ?>

    <?= $this->render('//bolster/_index', [
        'models' => $model->bolsters,
        'weight' => $model->getBolstersWeight()
    ]) ?>

</div>
