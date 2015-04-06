<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 22.02.15
 * Time: 20:41
 */

namespace app\models\FileInfo;

use app\models\Carriage;
use app\models\CarriageStatus;
use app\models\FileInfo;
use app\models\Warehouse;

class CommonFileParser {

    /**
     * @param FileInfo $file
     * @return Carriage[]
     * @throws \Exception
     */
    public function collectCommonFileContent(FileInfo $file) {
        if ($file->getFileType() != FileInfo::COMMON_FILE_TYPE) {
            throw new \Exception('Выбран неправильный формат файла');
        }
        $activeTable = $file->getFile()->getActiveSheet()->toArray(null, true, true, true);
        $carriageList = array();
        foreach ($activeTable as $carriage) {
            $curCarriage = $this->extractCarriageCommonInfo($carriage);
            if ($curCarriage) {
                $carriageList[$curCarriage->id] = $curCarriage;
            }
        }

        return $carriageList;
    }
    // todo добавить проверку на числовые значения
    protected function extractCarriageCommonInfo($carriageInfo) {
        if (empty($carriageInfo['A'])) {
            return false;
        }
        $carriage = new Carriage();
        $carriage->id = $carriageInfo['B'];
        $carriage->carriage_type = $carriageInfo['C'];
        $carriage->storage = Warehouse::getIdByName($carriageInfo['E']);
        $carriage->status = CarriageStatus::NEW_WITHOUT_INVENTORY;
        return $carriage;
    }
}