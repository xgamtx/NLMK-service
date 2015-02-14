<?php

/* @var $this yii\web\View */
/* @var $models app\models\WheelSet[] */
/* @var $weight float */

?>

<div class="wheel-set-block">
    <table class="table table-striped table-bordered detail-view">
        <thead>
        <tr>
            <td colspan="10">Надрессорная балка</td>
        </tr>
        <tr>
            <td colspan="3">№ надрессорной балки</td>
            <td>Год изготовления</td>
            <td>Завод изготовления</td>
            <td>Масса</td>
        </tr>
        </thead>
        <tbody>
        <? foreach ($models as $key => $model):?>
            <tr>
                <td><?=$model->id?></td>
                <td><?= empty($model->real_id) ? '<a href="#">задать</a>' : $model->real_id; ?></td>
                <td><a href="#<?=$model->id?>">Ссылка</a></td>
                <td><?=$model->produced_year?></td>
                <td><?=$model->factory?></td>
                <td><?=$model->mass?></td>
            </tr>
        <?endforeach;?>
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?=$weight?></td>
        </tr>
        </tfoot>
    </table>
</div>