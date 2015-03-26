<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CarriageStatus;

/* @var $this yii\web\View */
/* @var $model app\models\CarriageSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $statusList string[] */
?>

<div class="control-panel">
    <?php $form = ActiveForm::begin([
        'action' => ['set-stage'],
        'method' => 'post',
    ]); ?>
        <?= Html::hiddenInput('stage_id', 0, ['id' => 'stage_id']); ?>
        <?= Html::hiddenInput('carriage_id_list', '', ['id' => 'carriage_id_list']); ?>
        <?= Html::submitButton('Найти', ['style' => 'display: none']) ?>
    <?php ActiveForm::end();?>
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
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="return setCarriageStage(<?= CarriageStatus::ARRIVED; ?>)">Прибыл</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="return setCarriageStage(<?= CarriageStatus::CONFIRMED; ?>)">Утвержден на демонтаж</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="return setCarriageStage(<?= CarriageStatus::DESTROYED; ?>)">Демонтирован</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="return setCarriageStage(<?= CarriageStatus::ARCHIVE; ?>)">Архив</a></li>
        </ul>
    </div>
    <a href="#modal" role="button" class="btn btn-primary control-button" data-toggle="modal">Добавить</a>
    <?= Html::submitButton('Найти', ['class' => 'btn btn-primary control-button']) ?>
    <?= Html::a('Показать все', '/web/carriage/index', ['class' => 'btn btn-primary control-button']) ?>
    <div class="gluh"></div>
    <div class="input-group control-input"><?= Html::activeTextInput($model, 'id', ['class' => 'form-control', 'placeholder' => 'Номер вагона']);?></div>
    <div class="input-group control-input"><?= Html::activeTextInput($model, 'carriage_type', ['class' => 'form-control', 'placeholder' => 'Тип вагона']);?></div>
    <div class="input-group control-input"><?= Html::activeTextInput($model, 'storage', ['class' => 'form-control', 'placeholder' => 'ПЗУ']);?></div>
    <div class="dropdown control-button">
        <?= Html::activeDropDownList($model, 'status', $statusList, ['class' => "form-control"]);?>
    </div>
    <div class="input-group control-input"><input type="text" class="form-control" placeholder="Склад"></div>
    <div class="input-group control-input"><input type="text" class="form-control" placeholder="Прибыл с "></div>
    <div class="input-group control-input"><input type="text" class="form-control" placeholder="Прибыл по"></div>
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
    function setCarriageStage(stage) {
        var carriageIdList = getSelectedRows();
        $('#carriage_id_list').val(carriageIdList);
        $('#stage_id').val(stage);
        $('#w0').submit();

        return false;
    }
    function getSelectedRows() {
        return $('#w3').yiiGridView('getSelectedRows');
    }
</script>
