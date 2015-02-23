<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 14.02.15
 * Time: 17:21
 */

namespace app\models\WeightRetriever;

use app\models\WheelSet;

class WheelSetWeightRetriever {

    const MAX_WIDTH = 99999;

    protected static $massWeightConverter = array(
        array('min' => 700, 'max' => self::MAX_WIDTH, 'weight' => 1.414),
        array('min' => 650, 'max' => 700, 'weight' => 1.400),
        array('min' => 600, 'max' => 650, 'weight' => 1.368),
        array('min' => 550, 'max' => 600, 'weight' => 1.339),
        array('min' => 500, 'max' => 550, 'weight' => 1.307),
        array('min' => 450, 'max' => 500, 'weight' => 1.277),
        array('min' => 400, 'max' => 450, 'weight' => 1.244),
        array('min' => 350, 'max' => 400, 'weight' => 1.213),
        array('min' => 300, 'max' => 350, 'weight' => 1.180),
        array('min' => 0, 'max' => 300, 'weight' => 1.136),
    );

    /**
     * @param WheelSet $wheelSet
     * @return float
     * @throws \InvalidArgumentException
     */
    public static function getWeightWheelSet(WheelSet $wheelSet) {
        $maxWidth = max($wheelSet->left_wheel_width, $wheelSet->right_wheel_width);
        foreach (self::$massWeightConverter as $wheelSetType) {
            if (($maxWidth >= $wheelSetType['min']) && ($maxWidth <= $wheelSetType['max'])) {
                return $wheelSetType['weight'];
            }
        }
        throw new \InvalidArgumentException('Колесная пара находится вне дипазона толщин колес');
    }
}