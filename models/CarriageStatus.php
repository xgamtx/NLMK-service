<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 14.02.15
 * Time: 13:46
 */

namespace app\models;


class CarriageStatus {

    const NEW_WITHOUT_INVENTORY = 10;
    const NEW_WITH_INVENTORY = 20;
    const ARRIVED = 30;
    const WEIGHTED = 40;
    const ADOPTED = 50;
    const CONFIRMED = 60;
    const DESTROYED = 70;
    const STORAGE = 80;
    const ARCHIVE = 1000;

    protected static $labels = array(
        self::NEW_WITHOUT_INVENTORY => 'Новый без описи',
        self::NEW_WITH_INVENTORY => 'Новый с описью',
        self::ARRIVED => 'Прибыл',
        self::WEIGHTED => 'Взвешен',
        self::ADOPTED => 'Принят по описи',
        self::CONFIRMED => 'Утвержден на демонтаж',
        self::DESTROYED => 'Демонтирован',
        self::STORAGE => 'Склад',
        self::ARCHIVE => 'Архив',
    );

    public static function getLabelByStatusId($statusId) {
        if (isset(self::$labels[$statusId])) {
            return self::$labels[$statusId];
        }

        return null;
    }

    public static function getAllStatus() {
        return array('' => 'Все') + self::$labels;
    }
}