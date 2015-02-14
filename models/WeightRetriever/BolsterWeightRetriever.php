<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 14.02.15
 * Time: 17:21
 */

namespace app\models\WeightRetriever;

use app\models\Bolster;

class BolsterWeightRetriever {

    protected static $massWeightConverter = array(
        array('min' => 31, 'max' => 34, 'weight' => 0.471),
        array('min' => 26, 'max' => 30, 'weight' => 0.476),
        array('min' => 16, 'max' => 25, 'weight' => 0.498),
        array('min' => 1, 'max' => 15, 'weight' => 0.508),
    );

    /**
     * @param Bolster $bolster
     * @return float
     * @throws \InvalidArgumentException
     */
    public static function getWeightBolster(Bolster $bolster) {
        $age = date('Y') - $bolster->produced_year;
        foreach (self::$massWeightConverter as $bolsterType) {
            if (($age >= $bolsterType['min']) && ($age <= $bolsterType['max'])) {
                return $bolsterType['weight'];
            }
        }
        throw new \InvalidArgumentException('Надрессорная балка находится вне дипазона возрастов');
    }
}