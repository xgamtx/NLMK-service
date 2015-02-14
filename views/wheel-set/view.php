<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WheelSet */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => $model->getName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wheel-set-view">

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

    <?= $this->render('_view', [
        'model' => $model,
    ]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'produced_year',
            'factory',
            'right_wheel_width',
            'left_wheel_width',
            'real_produced_year',
            'real_factory',
            'carriage_id',
        ],
    ]) ?>

</div>
