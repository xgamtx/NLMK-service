<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 14.02.15
 * Time: 17:21
 */

namespace app\models\WeightRetriever;

use app\models\SideFrame;

class SideFrameWeightRetriever {

    protected static $massWeightConverter = array(
        array('min' => 11, 'max' => 37, 'weight' => 0.381),
        array('min' => 6, 'max' => 10, 'weight' => 0.386),
        array('min' => 1, 'max' => 5, 'weight' => 0.389),
    );

    /**
     * @param SideFrame $sideFrame
     * @return float
     * @throws \InvalidArgumentException
     */
    public static function getWeightSideFrame(SideFrame $sideFrame) {
        $age = date('Y') - $sideFrame->produced_year;
        foreach (self::$massWeightConverter as $sideFrameType) {
            if (($age >= $sideFrameType['min']) && ($age <= $sideFrameType['max'])) {
                return $sideFrameType['weight'];
            }
        }
        throw new \InvalidArgumentException('Боковая рама находится вне дипазона возрастов');
    }
}