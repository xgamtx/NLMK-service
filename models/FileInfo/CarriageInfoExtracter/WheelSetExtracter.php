<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 21.03.15
 * Time: 20:57
 */

namespace app\models\FileInfo\CarriageInfoExtracter;

use app\models\WheelSet;

class WheelSetExtracter extends BaseDetailExtracter {

    protected $dataForSearch = array(
        'id' => '№ колесной пары',
        'produced_year' => 'Год изготовления',
        'factory' => 'Завод изготовления',
        'right_wheel_width' => 'Толщина обода правого колеса',
        'left_wheel_width' => 'Толщина обода левого колеса'
    );

    public function isWheelSetHeader(array $row) {
        return preg_match('/№ колесной пары/', $row['A']);
    }

    /**
     * @param array $activeTable
     * @param int $startRowId
     * @param int $carriageId
     * @return WheelSet[]
     */
    public function extract($activeTable, $startRowId, $carriageId) {
        $assoc = $this->collectHeadData($activeTable[$startRowId]);
        if ($this->isStartDataInRow($activeTable, $startRowId + 1)) {
            $startDataRow = $startRowId + 1;
        } else {
            $startDataRow = $startRowId + 2;
        }
        $wheelSetList = array();
        for ($i = $startDataRow; $i < $startDataRow + 4; $i++) {
            $wheelSet = new WheelSet();
            foreach ($assoc as $field => $columnCode) {
                if ($field == 'factory') {
                    $wheelSet->factory = $this->extractFactoryId(trim($activeTable[$i][$columnCode]));
                } elseif (in_array($field, array('left_wheel_width', 'right_wheel_width'))) {
                    $wheelSet->{$field} = preg_replace('~[^0-9]+~', '', $activeTable[$i][$columnCode]);
                } else {
                    $wheelSet->{$field} = trim($activeTable[$i][$columnCode]);
                }
            }
            if ((int)$wheelSet->left_wheel_width > 100) {
                $wheelSet->left_wheel_width = $wheelSet->left_wheel_width / 10;
            }
            if ((int)$wheelSet->right_wheel_width > 100) {
                $wheelSet->right_wheel_width = $wheelSet->right_wheel_width / 10;
            }
            $wheelSet->carriage_id = $carriageId;
            $wheelSetList[] = $wheelSet;
        }
        return $wheelSetList;
    }
}