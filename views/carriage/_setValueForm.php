<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\db\ActiveRecord;

/* @var $this yii\web\View */
/* @var $model ActiveRecord */
/* @var $form yii\widgets\ActiveForm */
/* @var $url string */
/* @var $propertyName string */
/* @var $propertyLabel string */
?>
<?= Html::a('Установить', '#', [
    'class' => 'set-weight',
    'onclick' => '$(".carriage-form").hide();$(this).nextAll(".carriage-form").show();$(".set-weight").show();$(this).hide();return false;'
]);?>
<div class="carriage-form" style="display: none">

    <?php $form = ActiveForm::begin(['action' => [$url . '?id=' . $model->id]]); ?>
    <?= Html::activeHiddenInput($model, 'id');?>
    <?= Html::activeTextInput($model, $propertyName, ['class' => 'form-control input-xs brutto_weight_input', 'placeholder' => $propertyLabel, 'size' => 7]);?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-xs']) ?>

    <?php ActiveForm::end(); ?>

</div>
