<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Search\DictFactory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dict Factories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-factory-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dict Factory', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'dict_id',
            'short_name',
            'long_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
