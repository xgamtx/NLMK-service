<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 22.02.15
 * Time: 20:45
 */

namespace app\models\FileInfo;

use app\models\SideFrame;
use app\models\FileInfo;
use app\models\Carriage;
use app\models\WheelSet;
use app\models\Bolster;

class DetailFileParser {
    /**
     * @param FileInfo $file
     * @return Carriage
     * @throws \Exception
     */
    public function collectDetailFileContent(FileInfo $file) {
        if ($file->getFileType() != FileInfo::DETAIL_FILE_TYPE) {
            throw new \Exception('Выбран неправильный формат файла');
        }

        $activeTable = $file->getFile()->getActiveSheet()->toArray(null,true,true,true);
        $carriage = new Carriage();
        $carriageId = $this->getCarriageId($activeTable['4']['B']);
        if (!$carriageId) {
            throw new \Exception('Не найден ID вагона');
        }
        $wheelsetList = $this->getWheelSetList($activeTable, $carriageId);
        $sideFrameList = $this->getSideFrameList($activeTable, $carriageId);
        $bolsterList = $this->getBolsterList($activeTable, $carriageId);
        $carriage->id = $carriageId;
        $carriage->populateRelation(Carriage::WHEELSETS, $wheelsetList);
        $carriage->populateRelation(Carriage::SIDE_FRAMES, $sideFrameList);
        $carriage->populateRelation(Carriage::BOLSTERS, $bolsterList);
        return $carriage;
    }

    protected function getCarriageId($cell) {
        if (preg_match('/Опись номерных деталей  вагона №(.*)\./', $cell, $matches)) {
            return $matches[1];
        }
        return false;
    }

    protected function getWheelSetList($activeTable, $carriageId) {
        $wheelSetList = array();
        $rows = array(10, 11, 12, 13);
        foreach ($rows as $rowId) {
            $wheelSetList[] = $this->getWheelSet($activeTable[$rowId], $carriageId);
        }
        return $wheelSetList;
    }

    // todo добавить проверку на числовые значения
    protected function getWheelSet($wheelSetRow, $carriageId) {
        $wheelSet = new WheelSet();
        $wheelSet->factory = $wheelSetRow['E'];
        $wheelSet->produced_year = $wheelSetRow['C'];
        $wheelSet->id = trim($wheelSetRow['A']);
        $wheelSet->left_wheel_width = $wheelSetRow['I'];
        $wheelSet->right_wheel_width = $wheelSetRow['G'];
        $wheelSet->carriage_id = $carriageId;
        return $wheelSet;
    }

    protected function getSideFrameList($activeTable, $carriageId) {
        $sideFrameList = array();
        $rows = array(18, 19, 20, 21);
        foreach ($rows as $rowId) {
            $sideFrameList[] = $this->getSideFrame($activeTable[$rowId], $carriageId);
        }
        return $sideFrameList;
    }

    // todo добавить проверку на числовые значения
    protected function getSideFrame($row, $carriageId) {
        $sideFrame = new SideFrame();
        $sideFrame->id = $row['A'];
        $sideFrame->produced_year = $row['E'];
        $sideFrame->factory = $row['H'];
        $sideFrame->carriage_id = $carriageId;
        return $sideFrame;
    }

    protected function getBolsterList($activeTable, $carriageId) {
        $bolsterList = array();
        $rows = array(26, 27);
        foreach ($rows as $rowId) {
            $bolsterList[] = $this->getBolster($activeTable[$rowId], $carriageId);
        }
        return $bolsterList;
    }

    // todo добавить проверку на числовые значения
    protected function getBolster($row, $carriageId) {
        $bolster = new Bolster();
        $bolster->id = $row['A'];
        $bolster->produced_year = $row['E'];
        $bolster->factory = $row['H'];
        $bolster->carriage_id = $carriageId;
        return $bolster;
    }

}