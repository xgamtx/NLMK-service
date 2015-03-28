<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 21.03.15
 * Time: 20:33
 */

namespace app\models\FileInfo;


use app\models\Carriage;
use app\models\FileInfo\CarriageInfoExtracter\BolsterExtracter;
use app\models\FileInfo\CarriageInfoExtracter\SideFrameExtracter;
use app\models\FileInfo\CarriageInfoExtracter\WheelSetExtracter;

class CarriageInfoExtracter extends ExtracterBase {
    const SIDE_FRAME_COUNT_COLUMN = 3;
    /** @var WheelSetExtracter */
    protected $wheelSetExtracter;
    /** @var SideFrameExtracter */
    protected $sideFrameExtracter;
    /** @var BolsterExtracter */
    protected $bolsterExtracter;

    public function __construct() {
        $this->wheelSetExtracter = new WheelSetExtracter();
        $this->sideFrameExtracter = new SideFrameExtracter();
        $this->bolsterExtracter = new BolsterExtracter();
    }

    /**
     * @param array $dirtyCarriageInfo
     * @param int $carriageId
     * @return Carriage
     */
    public function extract(array $dirtyCarriageInfo, $carriageId) {
        $carriage = new Carriage();
        foreach ($dirtyCarriageInfo as $rowId => $rowContent) {
            if ($this->isWheelSetHeader($rowContent)) {
                $wheelSetList = $this->extractWheelSet($dirtyCarriageInfo, $rowId, $carriageId);
                $carriage->populateRelation(Carriage::WHEELSETS, $wheelSetList);
            } elseif ($this->isBolsterHeader($rowContent)) {
                $bolsterList = $this->extractBolster($dirtyCarriageInfo, $rowId, $carriageId);
                $carriage->populateRelation(Carriage::BOLSTERS, $bolsterList);
            } elseif ($this->isSideFrameHeader($rowContent)) {
                $sideFrameList = $this->extractSideFrame($dirtyCarriageInfo, $rowId, $carriageId);
                $carriage->populateRelation(Carriage::SIDE_FRAMES, $sideFrameList);
            }
        }
        return $carriage;
    }

    protected function isWheelSetHeader(array $row) {
        return $this->wheelSetExtracter->isWheelSetHeader($row);
    }

    protected function isSideFrameHeader(array $row) {
        return $this->sideFrameExtracter->isSideFrameHeader($row);
    }

    protected function isBolsterHeader(array $row) {
        return $this->bolsterExtracter->isBolsterHeader($row);
    }

    protected function extractWheelSet(array $activeTable, $rowStart, $carriageId) {
        return $this->wheelSetExtracter->extract($activeTable, $rowStart, $carriageId);
    }

    protected function extractSideFrame(array $activeTable, $rowStart, $carriageId) {
        return $this->sideFrameExtracter->extract($activeTable, $rowStart, $carriageId);
    }
    protected function extractBolster(array $activeTable, $rowStart, $carriageId) {
        return $this->bolsterExtracter->extract($activeTable, $rowStart, $carriageId);
    }


}
