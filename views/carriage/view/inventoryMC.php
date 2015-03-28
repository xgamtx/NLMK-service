<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\CarriageStatus;
use app\models\Carriage;
use app\models\UploadImage;

/* @var $this yii\web\View */
/* @var $model Carriage */

$this->title = $model->getName();
$this->params['breadcrumbs'][] = ['label' => 'Список вагонов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('//carriage/_navbar', [
    'selectTabId' => 5,
    'model' => $model
]) ?>
<div class="carriage-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('//wheel-set/_index', [
        'models' => $model->wheelsets,
        'weight' => $model->getWheelsetsWeight()
    ]) ?>

    <?= $this->render('//side-frame/_index', [
        'models' => $model->sideFrames,
        'weight' => $model->getSideFramesWeight()
    ]) ?>

    <?= $this->render('//bolster/_index', [
        'models' => $model->bolsters,
        'weight' => $model->getBolstersWeight()
    ]) ?>
    <div><?= !empty($model->im1) ?
        "<a href='/web/{$model->im1}' target='_blank'>Изображение1</a>" :
        $this->render('//carriage/_uploadCommonFileForm', [
            'model' => $model,
            'url' => 'carriage/save-image',
            'imageModel' => new UploadImage(),
            'propertyName' => 'im1'
        ]); ?></div>

    <div><?= !empty($model->im2) ?
        "<a href='/web/{$model->im2}' target='_blank'>Изображение2</a>" :
        $this->render('//carriage/_uploadCommonFileForm', [
            'model' => $model,
            'url' => 'carriage/save-image',
            'imageModel' => new UploadImage(),
            'propertyName' => 'im2'
        ]); ?></div>
    <div>
        <?= $this->render('//log/_index', [
            'models' => $model->getLogs()->all(),
        ]); ?>
    </div>

</div>
