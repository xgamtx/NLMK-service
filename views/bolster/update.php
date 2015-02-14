<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bolster */

$this->title = 'Update Bolster: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bolsters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bolster-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
