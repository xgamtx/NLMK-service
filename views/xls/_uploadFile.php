<?php
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'action' => ['xls/upload']
]);
?>
    <h2>Выберите файл для загрузки</h2>
<?= $form->field($model, 'file[]')->fileInput(['multiple' => true]) ?>

    <button>Загрузить</button>

<?php ActiveForm::end(); ?>