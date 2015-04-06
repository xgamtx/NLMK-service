<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\db\ActiveRecord;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model ActiveRecord */
/* @var $form yii\widgets\ActiveForm */
/* @var $url string */
/* @var $propertyName string */
/* @var $currentValue string */

if (empty($currentValue)) $currentValue = 'Установить';
?>
<?= Html::a($currentValue, '#', [
    'class' => 'set-weight',
    'onclick' => '$(".carriage-form").hide();$(this).nextAll(".carriage-form").show();$(".set-weight").show();$(this).hide();return false;'
]);?>
<div class="carriage-form" style="display: none">

    <?php $form = ActiveForm::begin(['action' => [$url . '?id=' . $model->id]]); ?>
    <?= Html::activeHiddenInput($model, 'id');?>
    <?= DatePicker::widget([
        'model' => $model,
        'attribute' => $propertyName,
        'language' => 'ru',
        'containerOptions' => [
            'class' => 'date-picker',
        ],
        'clientOptions' => [
            'autoclose' => true,
        ]
    ]);?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-xs']) ?>

    <?php ActiveForm::end(); ?>

</div>
