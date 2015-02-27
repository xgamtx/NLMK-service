<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Carriage */
/* @var $form yii\widgets\ActiveForm */
?>
<?= Html::a('Установить', '#', [
    'class' => 'set-weight',
    'onclick' => '$(".carriage-form").hide();$(this).nextAll(".carriage-form").show();$(".set-weight").show();$(this).hide();return false;'
]);?>
<div class="carriage-form" style="display: none">

    <?php $form = ActiveForm::begin(['action' => ['carriage/save_weight?id=' . $model->id]]); ?>
    <?= Html::activeHiddenInput($model, 'id');?>
    <?= Html::activeTextInput($model, 'brutto_weight', ['class' => 'form-control input-xs brutto_weight_input', 'placeholder' => 'Тара', 'size' => 4]);?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Сохранить', ['class' => 'btn btn-primary btn-xs']) ?>

    <?php ActiveForm::end(); ?>

</div>
