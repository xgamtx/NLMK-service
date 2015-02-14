<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\CarriageStatus;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

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
                'label' => 'status',
                'value' => CarriageStatus::getLabelByStatusId($model->status)
            ],
            'storage'
        ],
    ]) ?>

    <?= $this->render('//wheel-set/_index', [
        'models' => $model->getWheelsets()->all(),
    ]) ?>

    <?= $this->render('//side-frame/_index', [
        'models' => $model->getSideFrames()->all(),
    ]) ?>

    <?= $this->render('//bolster/_index', [
        'models' => $model->getBolsters()->all(),
    ]) ?>

</div>
