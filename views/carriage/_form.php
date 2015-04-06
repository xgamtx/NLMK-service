<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Carriage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carriage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'carriage_type')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'brutto_weight')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'storage')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'act_date')->widget(
        DatePicker::className(), [
        // inline too, not bad
        'inline' => true,
//        // modify template for custom rendering
//        'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
        'language' => 'ru',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
