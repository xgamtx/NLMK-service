<?php

use yii\helpers\Html;
use app\models\Carriage;
use app\controllers\CarriageController;

/* @var $this yii\web\View */
/* @var $model Carriage */
/* @var $content string */

$this->title = $model->getName();
$this->params['breadcrumbs'][] = ['label' => 'Список вагонов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('//carriage/_navbar', [
    'selectTabId' => 2,
    'model' => $model
]) ?>
<div class="carriage-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $content; ?>
    <?= Html::a('Скачать', ['carriage/save-xls', 'id' => $model->id, 'type' => CarriageController::DISASSEMBLING_ORDER]);?>

</div>
