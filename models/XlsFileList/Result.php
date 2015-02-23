<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 22.02.15
 * Time: 21:38
 */

namespace app\models\XlsFileList;

use app\models\Carriage;

class Result {
    public $failedParsingFile;
    /** @var Carriage[] */
    public $commonInfo;
    /** @var Carriage[] */
    public $detailInfo;
    /** @var array */
    protected $allCarriageIdList;

    public function getCarriageIdList() {
        if (empty($this->allCarriageIdList)) {
            $this->allCarriageIdList = $this->loadCarriageIdList();
        }
        return $this->allCarriageIdList;
    }

    protected function loadCarriageIdList() {
        $commonKey = array_keys($this->commonInfo);
        $detailKey = array_keys($this->detailInfo);
        return $commonKey + $detailKey;

    }
}