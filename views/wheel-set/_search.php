<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WheelSetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wheel-set-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'produced_year') ?>

    <?= $form->field($model, 'factory') ?>

    <?= $form->field($model, 'right_wheel_width') ?>

    <?= $form->field($model, 'left_wheel_width') ?>

    <?php // echo $form->field($model, 'real_produced_year') ?>

    <?php // echo $form->field($model, 'real_factory') ?>

    <?php // echo $form->field($model, 'carriage_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
