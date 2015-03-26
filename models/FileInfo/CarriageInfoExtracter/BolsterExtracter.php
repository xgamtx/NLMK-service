<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 21.03.15
 * Time: 20:57
 */

namespace app\models\FileInfo\CarriageInfoExtracter;

use app\models\Bolster;

class BolsterExtracter extends BaseDetailExtracter {

    protected $dataForSearch = array(
        'id' => '№ надрессорной балки',
        'produced_year' => 'Год изготовления',
        'factory' => 'Завод изготовления',

    );

    public function isBolsterHeader(array $row) {
        return preg_match('/№ надрессорной балки/', $row['A']);
    }

    /**
     * @param array $activeTable
     * @param int $startRowId
     * @param int $carriageId
     * @return Bolster[]
     */
    public function extract($activeTable, $startRowId, $carriageId) {
        $assoc = $this->collectHeadData($activeTable[$startRowId]);
        if ($this->isStartDataInRow($activeTable, $startRowId + 1)) {
            $startDataRow = $startRowId + 1;
        } else {
            $startDataRow = $startRowId + 2;
        }
        $bolsterList = array();
        for ($i = $startDataRow; $i < $startDataRow + 2; $i++) {
            $bolster = new Bolster();
            foreach ($assoc as $field => $columnCode) {
                $bolster->{$field} = trim($activeTable[$i][$columnCode]);
            }
            $bolster->carriage_id = $carriageId;
            $bolsterList[] = $bolster;
        }
        return $bolsterList;
    }
}