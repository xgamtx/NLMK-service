<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bolster */

$this->title = 'Create Bolster';
$this->params['breadcrumbs'][] = ['label' => 'Bolsters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bolster-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
