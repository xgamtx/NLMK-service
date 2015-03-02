<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UploadImage;
use app\models\Carriage;

/* @var $this yii\web\View */
/* @var $model Carriage */
/* @var $form yii\widgets\ActiveForm */
/* @var $url string */
/* @var $imageModel UploadImage */
/* @var $propertyName string */

?>
<?= Html::a('Загрузить', '#', [
    'class' => 'set-weight',
    'onclick' => '$(".carriage-form").hide();$(this).nextAll(".carriage-form").show();$(".set-weight").show();$(this).hide();return false;'
]);?>
<div class="carriage-form" style="display: none">

    <?php $form = ActiveForm::begin([
        'action' => [$url . '?id=' . $model->id . '&' . 'propertyName=' . $propertyName],
        'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= Html::activeFileInput($imageModel, 'file', ['class' => 'form-control input-sm brutto_weight_input']);?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-sm']) ?>

    <?php ActiveForm::end(); ?>

</div>
