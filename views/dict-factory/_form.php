<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DictFactory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dict-factory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dict_id')->textInput() ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'long_name')->textInput(['maxlength' => 150]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
