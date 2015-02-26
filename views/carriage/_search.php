<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CarriageSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $statusList string[] */
?>

<div class="control-panel">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="dropdown control-button">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-expanded="true">
            Действия
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Печать</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Сохранить</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Прибыл</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Утвержден на демонтаж</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Демонтирован</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Архив</a></li>
        </ul>
    </div>
    <a href="#" role="button" class="btn btn-primary control-button">Склад</a>
    <a href="#" role="button" class="btn btn-primary control-button">Архив</a>
    <a href="#modal" role="button" class="btn btn-primary control-button" data-toggle="modal">Добавить</a>
    <div class="gluh"></div>
    <div class="input-group control-input"><?= Html::activeTextInput($model, 'id', ['class' => 'form-control', 'placeholder' => 'Номер вагона']);?></div>
    <div class="input-group control-input"><?= Html::activeTextInput($model, 'carriage_type', ['class' => 'form-control', 'placeholder' => 'Тип вагона']);?></div>
    <div class="input-group control-input"><?= Html::activeTextInput($model, 'storage', ['class' => 'form-control', 'placeholder' => 'ПЗУ']);?></div>
    <a href="#" role="button" class="btn btn-primary control-button">М1</a>
    <a href="#" role="button" class="btn btn-primary control-button">М2</a>
    <a href="#" role="button" class="btn btn-primary control-button">М3</a>
    <div class="dropdown control-button">
        <?= Html::activeDropDownList($model, 'status', $statusList, ['class' => "form-control"]);?>
    </div>
    <div class="input-group control-input"><input type="text" class="form-control" placeholder="Склад"></div>
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary control-button']) ?>
    <div class="gluh"></div>
    <?php ActiveForm::end(); ?>
</div>

<div id="modal" class="modal">
    <div class="modal-dialog" style="background: #fff">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h2>Выберите файл для загрузки</h2>
            <?= $this->render(
                '//xls/_uploadFile',
                array('model' => new \app\models\UploadForm())
            ) ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('document').ready(function(){
        $('#modal').modal('false');
    });
    function filterStatus(statusId) {
        $('#statusInput').val(statusId);
    }
</script>
