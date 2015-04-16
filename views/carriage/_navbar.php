<?php

use app\models\Carriage;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $selectTabId int */
/* @var $model Carriage */
?>

<ul class="nav nav-tabs">
    <li role="presentation" class="<?= $selectTabId == 0 ? 'active' : ''?>">
        <?= Html::a('Данные вагона', ['carriage/view', 'id' => $model->id]);?>
    </li>
    <li role="presentation" class="<?= $selectTabId == 1 ? 'active' : ''?>">
        <?= Html::a('Опись вагона', ['carriage/inventory', 'id' => $model->id]);?>
    </li>
    <li role="presentation" class="<?= $selectTabId == 2 ? 'active' : ''?>">
        <? if ($model->isFullInfoEnabled()): ?>
        <?= Html::a('Заявка на демонтаж', ['carriage/disassembling-order', 'id' => $model->id]);?>
        <? else: ?>
            <?= Html::a('Заявка на демонтаж');?>
        <? endif; ?>
    </li>
    <li role="presentation" class="<?= $selectTabId == 3 ? 'active' : ''?>">
        <? if ($model->isFullInfoEnabled()): ?>
        <?= Html::a('Акт передачи вагона на демонтаж', ['carriage/disassembling-send', 'id' => $model->id]);?>
        <? else: ?>
            <?= Html::a('Акт передачи вагона на демонтаж');?>
        <? endif; ?>
    </li>
    <li role="presentation" class="<?= $selectTabId == 4 ? 'active' : ''?>">
        <? if ($model->isFullInfoEnabled()): ?>
        <?= Html::a('МХ-1', ['carriage/mh1', 'id' => $model->id]);?>
        <? else: ?>
            <?= Html::a('МХ-1');?>
        <? endif; ?>
    </li>
    <li role="presentation" class="<?= $selectTabId == 5 ? 'active' : ''?>">
        <? if ($model->isFullInfoEnabled()): ?>
        <?= Html::a('Опись МЦ', ['carriage/inventory-m-c', 'id' => $model->id]);?>
        <? else: ?>
            <?= Html::a('Опись МЦ');?>
        <? endif; ?>
    </li>
</ul>