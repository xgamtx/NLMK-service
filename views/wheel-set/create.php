<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WheelSet */

$this->title = 'Create Wheel Set';
$this->params['breadcrumbs'][] = ['label' => $model->getName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wheel-set-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
