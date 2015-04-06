<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 04.04.15
 * Time: 12:00
 */

namespace app\models;


class DateConverter {
    public static function convertToReadable($DbDate) {
        if (empty($DbDate)) {
            return $DbDate;
        }
        $extractedDate = new \DateTime($DbDate);
        return $extractedDate->format('d.m.Y');
    }

    public static function convertToDb($readableDate) {
        if (empty($readableDate)) {
            return $readableDate;
        }
        $extractedDate = new \DateTime($readableDate);
        return $extractedDate->format('Y-m-d');
    }
}