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

    protected static $availableForChangeStage = array(
        self::NEW_WITHOUT_INVENTORY => array(),
        self::NEW_WITH_INVENTORY => array(),
        self::ARRIVED => array(self::NEW_WITH_INVENTORY),
        self::WEIGHTED => array(),
        self::ADOPTED => array(),
        self::CONFIRMED => array(self::ADOPTED),
        self::DESTROYED => array(self::CONFIRMED),
        self::STORAGE => array(self::DESTROYED),
        self::ARCHIVE => array(
            self::NEW_WITHOUT_INVENTORY,
            self::NEW_WITH_INVENTORY,
            self::ARRIVED,
            self::WEIGHTED,
            self::ADOPTED,
            self::CONFIRMED,
            self::DESTROYED,
            self::STORAGE,
        ),
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

    public static function isAvailableForChange($stageId) {
        return self::$availableForChangeStage[$stageId] != array();
    }

    public static function isAvailableForChangeToStage($fromStageId, $toStageId) {
        return in_array((int)$fromStageId, self::$availableForChangeStage[$toStageId]);
    }
}