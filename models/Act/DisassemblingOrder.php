<?php
/**
 * Created by PhpStorm.
 * User: vasilij
 * Date: 11.04.15
 * Time: 17:37
 */

namespace app\models\Act;

use app\models\Carriage;
use app\models\DateConverter;
use app\models\Warehouse;

class DisassemblingOrder extends BaseAct {
    protected $actTemplatePath = '/web/disa.xlsx';

    protected function setModel(Carriage $carriage) {
        $this->valueForReplace = array(
            '{act_number}' => $carriage->act_number,
            '{act_date}' => DateConverter::convertToReadable($carriage->act_date),
            '{carriage_num}' => $carriage->id,
            '{carriage_type1}' => $carriage->carriage_type,
            '{storage}' => Warehouse::getNameById($carriage->storage),
            '{carriage_send_date}' => DateConverter::getMonth(2),
        );
    }
}