<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\db\ActiveRecord;
use app\models\UploadImage;

/* @var $this yii\web\View */
/* @var $model ActiveRecord */
/* @var $form yii\widgets\ActiveForm */
/* @var $url string */
/* @var $imageModel UploadImage */

?>
<?= Html::a('Загрузить', '#', [
    'class' => 'set-weight',
    'onclick' => '$(".carriage-form").hide();$(this).nextAll(".carriage-form").show();$(".set-weight").show();$(this).hide();return false;'
]);?>
<div class="carriage-form" style="display: none">

    <?php $form = ActiveForm::begin(['action' => [$url . '?id=' . $model->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= Html::activeFileInput($imageModel, 'file', ['class' => 'form-control input-sm brutto_weight_input']);?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-sm']) ?>

    <?php ActiveForm::end(); ?>

</div>
