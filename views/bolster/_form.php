<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bolster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bolster-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'produced_year')->textInput() ?>

    <?= $form->field($model, 'factory')->textInput() ?>

    <?= $form->field($model, 'carriage_id')->textInput() ?>

    <?= $form->field($model, 'real_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
