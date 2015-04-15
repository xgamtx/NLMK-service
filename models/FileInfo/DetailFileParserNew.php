<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 21.03.15
 * Time: 19:56
 */

namespace app\models\FileInfo;

use app\models\FileInfo;
use app\models\Carriage;

class DetailFileParserNew extends ExtracterBase {

    const LAST_ROW_SYMBOL = -1;

    protected $maxEmptyRow = 30;
    protected $maxColumnWithCarriageId = 3;
    /** @var CarriageInfoExtracter */
    protected $carriageInfoExtracter;

    public function __construct() {
        $this->carriageInfoExtracter = new CarriageInfoExtracter();
    }

    /**
     * @param FileInfo $file
     * @return Carriage[]
     * @throws \Exception
     */
    public function collectDetailFileContent(FileInfo $file) {
        if ($file->getFileType() != FileInfo::DETAIL_FILE_TYPE) {
            throw new \Exception('Выбран неправильный формат файла');
        }

        $activeTable = $file->getFile()->getActiveSheet()->toArray(null,true,true,true);
        $dirtyCarriageInfoList = $this->collectCarriageInfo($activeTable);
        $carriageList = array();
        foreach ($dirtyCarriageInfoList as $carriageId => $dirtyCarriageInfo) {
            $carriageInfo = $this->carriageInfoExtracter->extract($dirtyCarriageInfo, $carriageId);
            $carriageInfo->id = $carriageId;
            $carriageList[$carriageId] = $carriageInfo;
        }
        return $carriageList;
    }

    /**
     * @param array $activeTable
     * @return array array('carriageId' => row_start)
     */
    protected function getCarriageInfoStartRow(array $activeTable) {
        $currentRowId = 0;
        $lastUsefulRow = 0;
        /** @var array $carriageInfo array('carriageId' => row_start) */
        $carriageInfo = array();
        while ($currentRowId - $this->maxEmptyRow < $lastUsefulRow) {
            $currentRowId++;
            if (!isset($activeTable[$currentRowId])) {
                break;
            }
            if (!empty($activeTable[$currentRowId]['A']))  {
                $lastUsefulRow = $currentRowId;
            }
            $carriageId = $this->getCarriageIdFromRow($activeTable[$currentRowId]);
            if (!empty($carriageId)) {
                $carriageInfo[$carriageId] = $currentRowId;
            }
        }
        $carriageInfo[self::LAST_ROW_SYMBOL] = $lastUsefulRow + 1;
        return $carriageInfo;
    }

    protected function collectCarriageInfo(array $activeTable) {
        $carriageInfoStartRow = $this->getCarriageInfoStartRow($activeTable);
        $result = array();
        $lastCarriageId = null;
        $lastCarriageStartRow = null;
        foreach ($carriageInfoStartRow as $carriageId => $startRowId) {
            if (!empty($lastCarriageId) && !empty($lastCarriageStartRow)) {
                $result[$lastCarriageId] = $this->getDirtyCarriageInfo($activeTable, $lastCarriageStartRow, $startRowId);
            }
            $lastCarriageId = $carriageId;
            $lastCarriageStartRow = $startRowId;
        }

        return $result;
    }

    protected function getDirtyCarriageInfo($activeTable, $rowStart, $rowEnd) {
        $result = array();
        for ($i = $rowStart; $i < $rowEnd; $i++) {
            $result[] = $activeTable[$i];
        }
        return $result;
    }

    /**
     * @param array $row
     * @return int|null
     */
    protected function getCarriageIdFromRow(array $row) {
        for ($i = 0; $i < $this->maxColumnWithCarriageId; $i++) {
            $columnCode = $this->getColumnCode($i + 1);
            $carriageId = $this->getCarriageId($row[$columnCode]);
            if ($carriageId) {
                return $carriageId;
            }
        }
        return null;
    }

    /**
     * @param $cellContent
     * @return null|int
     */
    protected function getCarriageId($cellContent) {
        if (preg_match('/Акт переписи номерных деталей вагона №(.*)/', $cellContent, $matches)) {
            return $matches[1];
        } elseif (preg_match('/Опись номерных деталей  вагона №(.*)\./', $cellContent, $matches)) {
            return $matches[1];
        } elseif (preg_match('/Акт технического состояния грузового вагона № (.*)/', $cellContent, $matches)) {
            return $matches[1];
        } elseif (preg_match('/Опись номерных деталей  вагона №([0-9]*)./', $cellContent, $matches)) {
            return $matches[1];
        } else {
            return null;
        }
    }

}