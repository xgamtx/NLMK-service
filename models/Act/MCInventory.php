<?php
/**
 * Created by PhpStorm.
 * User: vasilij
 * Date: 11.04.15
 * Time: 21:51
 */

namespace app\models\Act;

use app\models\Carriage;
use app\models\DateConverter;
use app\models\Warehouse;
use app\models\WheelSet;
use app\models\Bolster;
use app\models\SideFrame;

class MCInventory extends BaseAct {
    protected $actTemplatePath = '/web/disa4.xlsx';

    protected function setModel(Carriage $carriage) {
        /** @var WheelSet[] $wheelSets */
        $wheelSets = $carriage->getWheelsets()->all();
        /** @var Bolster[] $bolsters */
        $bolsters = $carriage->getBolsters()->all();
        /** @var SideFrame[] $sideFrames */
        $sideFrames = $carriage->getSideFrames()->all();
        $this->valueForReplace = array(
            '{act_number}' => $carriage->act_number,
            '{act_date}' => DateConverter::convertToReadable($carriage->act_date),
            '{carriage_num}' => $carriage->id,
            '{storage}' => Warehouse::getNameById($carriage->storage),
            '{carriage_type2}' => $carriage->carriage_type,
            '{wheelset_1_num}' => empty($wheelSets[0]->real_id) ? $wheelSets[0]->id : $wheelSets[0]->real_id,
            '{wheelset_2_num}' => empty($wheelSets[1]->real_id) ? $wheelSets[1]->id : $wheelSets[1]->real_id,
            '{wheelset_3_num}' => empty($wheelSets[2]->real_id) ? $wheelSets[2]->id : $wheelSets[2]->real_id,
            '{wheelset_4_num}' => empty($wheelSets[3]->real_id) ? $wheelSets[3]->id : $wheelSets[3]->real_id,
            '{wheelset_1_description}' => $wheelSets[0]->getPartInfo()->description,
            '{wheelset_2_description}' => $wheelSets[1]->getPartInfo()->description,
            '{wheelset_3_description}' => $wheelSets[2]->getPartInfo()->description,
            '{wheelset_4_description}' => $wheelSets[3]->getPartInfo()->description,
            '{wheelset_1_factory_num}' => $wheelSets[0]->factory,
            '{wheelset_2_factory_num}' => $wheelSets[1]->factory,
            '{wheelset_3_factory_num}' => $wheelSets[2]->factory,
            '{wheelset_4_factory_num}' => $wheelSets[3]->factory,
            '{wheelset_1_factory_year}' => $wheelSets[0]->produced_year,
            '{wheelset_2_factory_year}' => $wheelSets[1]->produced_year,
            '{wheelset_3_factory_year}' => $wheelSets[2]->produced_year,
            '{wheelset_4_factory_year}' => $wheelSets[3]->produced_year,
            '{wheelset_1_width}' => min($wheelSets[0]->left_wheel_width, $wheelSets[0]->right_wheel_width),
            '{wheelset_2_width}' => min($wheelSets[1]->left_wheel_width, $wheelSets[1]->right_wheel_width),
            '{wheelset_3_width}' => min($wheelSets[2]->left_wheel_width, $wheelSets[2]->right_wheel_width),
            '{wheelset_4_width}' => min($wheelSets[3]->left_wheel_width, $wheelSets[3]->right_wheel_width),
            '{wheelset_1_type}' => $wheelSets[0]->getWheelSetType(),
            '{wheelset_2_type}' => $wheelSets[1]->getWheelSetType(),
            '{wheelset_3_type}' => $wheelSets[2]->getWheelSetType(),
            '{wheelset_4_type}' => $wheelSets[3]->getWheelSetType(),
            '{bolster_1_num}' => empty($bolsters[0]->real_id) ? $bolsters[0]->id : $bolsters[0]->real_id,
            '{bolster_2_num}' => empty($bolsters[1]->real_id) ? $bolsters[1]->id : $bolsters[1]->real_id,
            '{bolster_1_description}' => $bolsters[0]->getPartInfo()->description,
            '{bolster_2_description}' => $bolsters[1]->getPartInfo()->description,
            '{bolster_1_factory_num}' => $bolsters[0]->factory,
            '{bolster_2_factory_num}' => $bolsters[1]->factory,
            '{bolster_1_factory_year}' => $bolsters[0]->produced_year,
            '{bolster_2_factory_year}' => $bolsters[1]->produced_year,
            '{side_frame_1_num}' => empty($sideFrames[0]->real_id) ? $sideFrames[0]->id : $sideFrames[0]->real_id,
            '{side_frame_2_num}' => empty($sideFrames[1]->real_id) ? $sideFrames[1]->id : $sideFrames[1]->real_id,
            '{side_frame_3_num}' => empty($sideFrames[2]->real_id) ? $sideFrames[2]->id : $sideFrames[2]->real_id,
            '{side_frame_4_num}' => empty($sideFrames[3]->real_id) ? $sideFrames[3]->id : $sideFrames[3]->real_id,
            '{side_frame_1_description}' => $sideFrames[0]->getPartInfo()->description,
            '{side_frame_2_description}' => $sideFrames[1]->getPartInfo()->description,
            '{side_frame_3_description}' => $sideFrames[2]->getPartInfo()->description,
            '{side_frame_4_description}' => $sideFrames[3]->getPartInfo()->description,
            '{side_frame_1_factory_num}' => $sideFrames[0]->factory,
            '{side_frame_2_factory_num}' => $sideFrames[1]->factory,
            '{side_frame_3_factory_num}' => $sideFrames[2]->factory,
            '{side_frame_4_factory_num}' => $sideFrames[3]->factory,
            '{side_frame_1_factory_year}' => $sideFrames[0]->produced_year,
            '{side_frame_2_factory_year}' => $sideFrames[1]->produced_year,
            '{side_frame_3_factory_year}' => $sideFrames[2]->produced_year,
            '{side_frame_4_factory_year}' => $sideFrames[3]->produced_year,
            '{act_number2}' => $carriage->act_number_2,
        );
    }
}