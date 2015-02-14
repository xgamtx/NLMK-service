<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Carriage */

$this->title = 'Create Carriage';
$this->params['breadcrumbs'][] = ['label' => 'Carriages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carriage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
