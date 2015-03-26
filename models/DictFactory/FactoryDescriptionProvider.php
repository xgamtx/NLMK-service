<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 26.03.15
 * Time: 20:08
 */

namespace app\models\DictFactory;


use app\models\DictFactory;

class FactoryDescriptionProvider {
    /**
     * @param string $fileName
     * @return DictFactory[]
     */
    public function getFromFile($fileName) {
        $activeTable = $this->getActiveTable($fileName);
        return $this->getFactoryDescriptionList($activeTable);
    }

    protected function getActiveTable($fileName) {
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        /** @var \PHPExcel $fileContent */
        $fileContent = $objReader->load($fileName);
        return $fileContent->getActiveSheet()->toArray(null,true,true,true);
    }

    protected function getFactoryDescriptionList($activeTable) {
        $rowId = 2;
        $factoryList = array();
        while (isset($activeTable[$rowId]['A']) && !empty($activeTable[$rowId]['A'])) {
            $factoryList[] = $this->getFactoryDescription($activeTable[$rowId]);
            $rowId++;
        }
        return $factoryList;
    }

    protected function getFactoryDescription($row) {
        $factory = new DictFactory();
        $factory->dict_id = $this->clearDictId($row['A']);
        $factory->long_name = $row['B'];
        $factory->short_name = $row['C'];
        return $factory;
    }

    protected function clearDictId($dirtyDictId) {
        $partList = explode(',', $dirtyDictId);
        return $partList[0];
    }
}