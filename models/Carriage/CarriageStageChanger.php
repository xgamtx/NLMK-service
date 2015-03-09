<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 09.03.15
 * Time: 13:28
 */

namespace app\models\Carriage;

use app\models\Carriage;

class CarriageStageChanger {
    /** @var Carriage[] */
    protected $carriageList;
    /** @var int */
    protected $stageId;

    public function __construct(array $postData) {
        if (!isset($postData['stage_id']) || !isset($postData['carriage_id_list'])) {
            return;
        }

        $this->carriageList = Carriage::findAll(explode(',', $postData['carriage_id_list']));
        $this->stageId = $postData['stage_id'];
    }

    public function changeStage() {
        foreach ($this->carriageList as $carriage) {
            $carriage->changeStage($this->stageId);
        }
    }
}