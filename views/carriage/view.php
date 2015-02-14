<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\CarriageStatus;

/* @var $this yii\web\View */
/* @var $model app\models\Carriage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carriages', 'url' => ['index']];
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
                'label' => 'status',
                'value' => CarriageStatus::getLabelByStatusId($model->status)
            ]
        ],
    ]) ?>
</div>
