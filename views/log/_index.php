<?php

/* @var $this yii\web\View */
/* @var $models app\models\Log[] */
?>

<div class="wheel-set-block">
    <table class="table table-striped table-bordered detail-view">
        <thead>
        <tr>
            <td colspan="10">Архив</td>
        </tr>
        <tr>
            <td>№</td>
            <td>Дата</td>
            <td>Содержание</td>
        </tr>
        </thead>
        <tbody>
        <? foreach ($models as $key => $model):?>
            <tr>
                <td><?= $key + 1; ?></td>
                <td><?= $model->datetime; ?></td>
                <td><?= $model->message?></td>
            </tr>
        <?endforeach;?>
        </tbody>
    </table>
</div>