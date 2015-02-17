<?php
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'action' => ['upload/upload']
]);
?>

<?= $form->field($model, 'file[]')->fileInput(['multiple' => true]) ?>

    <button>Загрузить</button>

<?php ActiveForm::end(); ?>