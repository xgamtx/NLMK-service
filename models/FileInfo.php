<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "file_info".
 *
 * @property integer $id
 * @property string $name
 * @property integer $author
 * @property string $date_create
 */
class FileInfo extends ActiveRecord
{

    const EXCEL_TYPE = 'Excel5';

    const COMMON_FILE_TYPE = 'common';
    const DETAIL_FILE_TYPE = 'detail';

    /** @var \PHPExcel */
    protected $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'author'], 'required'],
            [['author'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 240]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'author' => 'Author',
            'date_create' => 'Date Create',
        ];
    }

    protected function loadFile() {
        if (!empty($this->file)) {
            return true;
        }

        if (file_exists($this->name)) {
            //todo обработать случай другого excel
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            if (!$objReader->canRead($this->name)) {
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
                if (!$objReader->canRead($this->name)) {
                    return false;
                }
            }
            $this->file = $objReader->load($this->name);
            return true;
        }
        return false;
    }

    public function getFileType() {
        if (!$this->loadFile()) {
            throw new \Exception('Файл не найден');
        }

        $activeTable = $this->file->getActiveSheet()->toArray(null,true,true,true);
        if ((preg_match('/Опись номерных деталей  вагона №(.*)./', $activeTable[4]['B'], $matches)) ||
            preg_match('/Акт технического состояния грузового вагона № (.*)/', $activeTable[1]['A'], $matches) ||
            preg_match('/Опись номерных деталей  вагона №([0-9]*)./', $activeTable[1]['B'], $matches)) {
            return self::DETAIL_FILE_TYPE;
        } else {
            return self::COMMON_FILE_TYPE;
        }
    }

    public function clear() {
        $date = date('Y-m-d H:i:s', time() - 24 * 3600);
        $fileList = $this->find()->where("date_create < :date_create", array('date_create' => $date))->all();
        foreach ($fileList as $file) {
            $file->delete();
        }
    }

    public function getFile() {
        $this->loadFile();
        return $this->file;
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            if (file_exists($this->name)) {
                return unlink($this->name);
            }
            return true;
        } else {
            return false;
        }
    }
}
