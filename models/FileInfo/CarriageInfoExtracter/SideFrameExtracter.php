<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 21.03.15
 * Time: 20:57
 */

namespace app\models\FileInfo\CarriageInfoExtracter;

use app\models\SideFrame;

class SideFrameExtracter extends BaseDetailExtracter {

    protected $dataForSearch = array(
        'id' => '№ боковой рамы',
        'produced_year' => 'Год изготовления',
        'factory' => 'Завод изготовления',
    );

    public function isSideFrameHeader(array $row) {
        return preg_match('/№ боковой рамы/', $row['A']);
    }

    /**
     * @param array $activeTable
     * @param int $startRowId
     * @param int $carriageId
     * @return SideFrame[]
     */
    public function extract($activeTable, $startRowId, $carriageId) {
        $assoc = $this->collectHeadData($activeTable[$startRowId]);
        if ($this->isStartDataInRow($activeTable, $startRowId + 1)) {
            $startDataRow = $startRowId + 1;
        } else {
            $startDataRow = $startRowId + 2;
        }
        $sideFrameList = array();
        for ($i = $startDataRow; $i < $startDataRow + 4; $i++) {
            $sideFrame = new SideFrame();
            foreach ($assoc as $field => $columnCode) {
                if ($field == 'factory') {
                    $sideFrame->factory = $this->extractFactoryId(trim($activeTable[$i][$columnCode]));
                } else {
                    $sideFrame->{$field} = trim($activeTable[$i][$columnCode]);
                }

            }
            $sideFrame->carriage_id = $carriageId;
            $sideFrameList[] = $sideFrame;
        }
        return $sideFrameList;
    }

}