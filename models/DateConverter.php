<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 04.04.15
 * Time: 12:00
 */

namespace app\models;


class DateConverter {
    protected static $monthRu = array('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');

    public static function convertToReadable($dbDate) {
        if (empty($dbDate)) {
            return $dbDate;
        }
        $extractedDate = new \DateTime($dbDate);
        return $extractedDate->format('d.m.Y');
    }

    public static function convertToDb($readableDate) {
        if (empty($readableDate)) {
            return $readableDate;
        }
        try {
            $extractedDate = new \DateTime($readableDate);
        } catch (\Exception $e) {
            return null;
        }
        return $extractedDate->format('Y-m-d');
    }

    public static function getMonth($monthNum) {
        return self::$monthRu[$monthNum];
    }
}