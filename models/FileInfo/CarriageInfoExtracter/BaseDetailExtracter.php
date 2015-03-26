<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 21.03.15
 * Time: 21:11
 */

namespace app\models\FileInfo\CarriageInfoExtracter;


use app\models\DictFactory;
use app\models\FileInfo\ExtracterBase;

class BaseDetailExtracter extends ExtracterBase {

    protected $dataForSearch = array();

    protected function collectHeadData(array $row) {
        $headData = array();
        for ($i = 1; $i < self::MAX_USEFUL_COLUMN_ID; $i++) {
            $columnCode = $this->getColumnCode($i);
            $columnValue = $row[$columnCode];
            $relativeHeadCode = $this->findHeadType($columnValue);
            if ($relativeHeadCode) {
                $headData[$relativeHeadCode] = $columnCode;
            }

            if (count($headData) == count($this->dataForSearch)) {
                return $headData;
            }
        }
        return $headData;
    }

    private function isEqualData($columnData, $requiredData) {
        return preg_match("/{$requiredData}/", $columnData);
    }

    private function findHeadType($columnValue) {
        foreach ($this->dataForSearch as $headCode => $headContent) {
            if (!isset($headData[$headCode])) {
                if ($this->isEqualData($columnValue, $headContent)) {
                    return $headCode;
                }
            }
        }
        return null;
    }

    protected function isStartDataInRow($activeTable, $rowId) {
        return is_numeric($activeTable[$rowId]['A']);
    }

    protected function extractFactoryId($factoryContent) {
        if (is_numeric($factoryContent)) {
            return DictFactory::getIdByDictId($factoryContent);
        }

        return DictFactory::getIdByName($factoryContent);
    }
}