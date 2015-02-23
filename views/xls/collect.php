<?php

use app\models\Carriage;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $newCarriageList app\models\XlsFileList\Result */
/* @var $oldCarriageList Carriage[] */
/* @var $authorId int */

?>
<?php $form = ActiveForm::begin([
    'action' => ['save'],
    'method' => 'post',
]);
?>
<a href="#" class="btn btn-default" onclick="return selectValid()">Выбрать валидные</a>
<a href="#" class="btn btn-default" onclick="return selectAll()">Выбрать Все</a>
<a href="#" class="btn btn-default" onclick="return deselectAll()">Снять выделение</a>

<table style="margin-bottom: 30px">
    <thead>
    <tr><td>Номер вагона</td><td>Общая информация</td><td>Детальная информация</td></tr>
    </thead>
<? foreach ($newCarriageList->getCarriageIdList() as $carriageId): ?>
    <?
    $oldCarriage = isset($oldCarriageList[$carriageId]) ? $oldCarriageList[$carriageId] : new Carriage();
    $validCommonData = isset($newCarriageList->commonInfo[$carriageId]) ^ $oldCarriage->isCommonInfoEnabled();
    $validDetailData = !(isset($newCarriageList->detailInfo[$carriageId]) && $oldCarriage->isFullInfoEnabled());
    ?>
    <tr>
        <td><?= $carriageId; ?></td>
        <td class="<?= $validCommonData ? 'valid_col' : 'invalid_col' ?>">
            <? if (isset($newCarriageList->commonInfo[$carriageId])):?>
            <label><input type="checkbox" name="common[<?= $carriageId?>]" checked>Добавить</label>
            <?else:?>
                -
            <?endif;?>
        </td>
        <td class="<?= $validDetailData ? 'valid_col' : 'invalid_col' ?>">
            <? if (isset($newCarriageList->detailInfo[$carriageId])):?>
                <label><input type="checkbox" name="detail[<?= $carriageId?>]" checked>Добавить</label>
            <?else:?>
                -
            <?endif;?>
        </td>
    </tr>
<?endforeach;?>
</table>
<input type="hidden" name="author_id" value="<?= $authorId?>">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
    function selectValid() {
        $('.valid_col input').prop('checked', true);
        $('.invalid_col input').prop('checked', false);
        return false;
    }
    function selectAll() {
        $('.valid_col input').prop('checked', true);
        $('.invalid_col input').prop('checked', true);
        return false;
    }
    function deselectAll() {
        $('.valid_col input').prop('checked', false);
        $('.invalid_col input').prop('checked', false);
        return false;
    }

</script>