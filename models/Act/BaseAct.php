<?php
/**
 * Created by PhpStorm.
 * User: vasilij
 * Date: 11.04.15
 * Time: 17:37
 */

namespace app\models\Act;

use app\models\Carriage;
use Yii;
use PHPExcel_IOFactory;
use PHPExcel;

class BaseAct {

    const HTML = 'HTML';
    const EXCEL = 'Excel2007';

    const MAX_USEFUL_COLUMN_ID = 55;

    /** @var string */
    protected $actTemplatePath;
    /** @var PHPExcel */
    protected $phpExcel;
    protected $valueForReplace;
    /** @var bool */
    protected $isConverted;

    protected function load() {
        $inputFileName = Yii::$app->basePath . $this->actTemplatePath;
        $this->phpExcel = PHPExcel_IOFactory::load($inputFileName);
        $this->isConverted = false;
    }

    public function save($fileName, $requiredFormat = self::HTML) {
        if (!$this->isConverted) {
            throw new \Exception('Данные не конвертированы');
        }
        $objWriter = PHPExcel_IOFactory::createWriter($this->phpExcel, $requiredFormat);
        if ($requiredFormat == self::HTML) {
            /** @var \PHPExcel_Writer_HTML $objWriter */
            $objWriter->setUseInlineCss(true);
        }
        $objWriter->save($fileName);
    }

    protected function replaceTemplate($template, $value) {
        foreach ($this->phpExcel->getActiveSheet()->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $cell->setValue(str_replace($template, $value, $cell->getValue()));
            }
        }
    }

    public function convert(Carriage $carriage) {
        $this->load();
        $this->setModel($carriage);
        foreach ($this->valueForReplace as $template => $value) {
            $this->replaceTemplate($template, $value);
        }
        $this->isConverted = true;
    }

    protected function setModel(Carriage $carriage) {
        $this->valueForReplace = array();
    }
}