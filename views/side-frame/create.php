<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SideFrame */

$this->title = 'Create Side Frame';
$this->params['breadcrumbs'][] = ['label' => 'Side Frames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="side-frame-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
