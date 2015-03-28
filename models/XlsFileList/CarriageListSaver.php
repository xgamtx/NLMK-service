<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 23.02.15
 * Time: 10:26
 */

namespace app\models\XlsFileList;


use app\models\Carriage;
use app\models\CarriageStatus;

class CarriageListSaver {
    /**
     * @param array $postRequest
     * @param Result $carriageList
     */
    public function save($postRequest, Result $carriageList) {
        if (isset($postRequest['common'])) {
            $this->saveCommonData($postRequest['common'], $carriageList->commonInfo);
        }

        if (isset($postRequest['detail'])) {
            $this->saveDetailData($postRequest['detail'], $carriageList->detailInfo);
        }
    }

    /**
     * @param int[] $carriageIdList
     * @param Carriage[] $carriageList
     */
    protected function saveCommonData($carriageIdList, $carriageList) {
        foreach ($carriageIdList as $carriageId => $checked) {
            if (!isset($carriageList[$carriageId]) || ($checked != 'on')) {
                continue;
            }
            $carriage = $carriageList[$carriageId];
            $oldCarriage = $this->getCarriageById($carriageId);
            $newCarriage = $this->addCommonData($oldCarriage, $carriage);
            if ($oldCarriage->status < CarriageStatus::NEW_WITHOUT_INVENTORY) {
                $newCarriage->status = CarriageStatus::NEW_WITHOUT_INVENTORY;
            }
            $newCarriage->save();
        }
    }

    /**
     * @param int[] $carriageIdList
     * @param Carriage[] $carriageList
     */
    protected function saveDetailData($carriageIdList, $carriageList) {
        foreach ($carriageIdList as $carriageId => $checked) {
            if (!isset($carriageList[$carriageId]) || ($checked != 'on')) {
                continue;
            }
            $carriage = $carriageList[$carriageId];
            $oldCarriage = $this->getCarriageById($carriageId);
            $newCarriage = $this->addDetailData($oldCarriage, $carriage);
            if ($oldCarriage->status < CarriageStatus::NEW_WITH_INVENTORY);
            {
                $newCarriage->status = CarriageStatus::NEW_WITH_INVENTORY;
            }
            $newCarriage->save();
        }
    }

    /**
     * @param int $carriageId
     * @return Carriage
     */
    protected function getCarriageById($carriageId) {
        $carriage = Carriage::find()->where('id= :carriageId', array('carriageId' => $carriageId))->one();
        if (!$carriage) {
            $carriage = new Carriage();
            $carriage->id = $carriageId;
            $carriage->save();
        }
        return $carriage;
    }

    protected function addCommonData(Carriage $oldCarriage, Carriage $newCarriage) {
        $oldCarriage->carriage_type = $newCarriage->carriage_type;
        $oldCarriage->storage = $newCarriage->storage;
        $oldCarriage->status = $newCarriage->status;
        return $oldCarriage;
    }

    protected function addDetailData(Carriage $oldCarriage, Carriage $newCarriage) {
        $oldCarriage = $this->deleteDetailData($oldCarriage);
        $relatedData = $newCarriage->getRelatedRecords();
        $oldCarriage->addRelatedData(Carriage::WHEELSETS, $relatedData[Carriage::WHEELSETS]);
        $oldCarriage->addRelatedData(Carriage::SIDE_FRAMES, $relatedData[Carriage::SIDE_FRAMES]);
        $oldCarriage->addRelatedData(Carriage::BOLSTERS, $relatedData[Carriage::BOLSTERS]);

        return $oldCarriage;
    }

    /**
     * @param Carriage $oldCarriage
     * @return Carriage
     * @throws \Exception
     */
    protected function deleteDetailData(Carriage $oldCarriage) {
        foreach ($oldCarriage->wheelsets as $wheelset) {
            $wheelset->delete();
        }

        foreach ($oldCarriage->bolsters as $bolster) {
            $bolster->delete();
        }

        foreach ($oldCarriage->sideFrames as $sideFrame) {
            $sideFrame->delete();
        }
        return $this->getCarriageById($oldCarriage->id);
    }
}