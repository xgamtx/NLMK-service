<?php

use app\models\UploadImage;

/* @var $this yii\web\View */
/* @var $models app\models\SideFrame[] */
/* @var $weight float */

?>

<div class="wheel-set-block">
    <table class="table table-striped table-bordered detail-view">
        <thead>
        <tr>
            <td colspan="10">Боковая рама</td>
        </tr>
        <tr>
            <td colspan="3">№ боковой рамы</td>
            <td>Год изготовления</td>
            <td>Завод изготовления</td>
            <td>Масса</td>
        </tr>
        </thead>
        <tbody>
        <? foreach ($models as $key => $model):?>
            <tr>
                <td><?=$model->id?></td>
                <td><?= !empty($model->real_id) ?
                        $model->real_id :
                        $this->render('//carriage/_setValueForm', [
                            'model' => $model,
                            'propertyName' => 'real_id',
                            'propertyLabel' => 'ID',
                            'url' => 'side-frame/save-real-id'
                        ]);
                    ?></td>
                <td><?= !empty($model->image_src) ?
                        "<a href='/web/{$model->image_src}' target='_blank'>Просмотр</a>" :
                        $this->render('//carriage/_uploadFileForm', [
                            'model' => $model,
                            'url' => 'side-frame/save-image',
                            'imageModel' => new UploadImage()
                        ]);
                    ?></td>
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