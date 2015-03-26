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
                $wheelSet->{$field} = trim($activeTable[$i][$columnCode]);
            }
            $wheelSet->carriage_id = $carriageId;
            $wheelSetList[] = $wheelSet;
        }
        return $wheelSetList;
    }
}