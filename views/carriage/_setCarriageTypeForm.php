<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Carriage;

/* @var $this yii\web\View */
/* @var $model Carriage */
/* @var $form yii\widgets\ActiveForm */
/* @var $currentValue string */

if (empty($currentValue)) $currentValue = 'Установить';
?>
<?= Html::a($currentValue, '#', [
    'class' => 'set-weight',
    'onclick' => '$(".carriage-form").hide();$(this).nextAll(".carriage-form").show();$(".set-weight").show();$(this).hide();return false;'
]);?>
<div class="carriage-form" style="display: none">

    <?php $form = ActiveForm::begin(['action' => ['carriage/update?id=' . $model->id]]); ?>
    <?= Html::activeDropDownList($model, 'carriage_type',
        [
            'Цементовоз' => 'Цементовоз',
            'Полувагон' => 'Полувагон'
        ]) ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-xs']) ?>

    <?php ActiveForm::end(); ?>

</div>
