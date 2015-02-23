<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 22.02.15
 * Time: 20:49
 */

namespace app\models;


use app\models\FileInfo\CommonFileParser;
use app\models\FileInfo\DetailFileParser;
use app\models\XlsFileList\Result;
use app\models\XlsFileList\CarriageListSaver;

class XlsFileList {
    /** @var CommonFileParser */
    protected $commonInfoParser;
    /** @var DetailFileParser */
    protected $detailInfoParser;
    /** @var CarriageListSaver */
    protected $carriageListSaver;

    public function __construct() {
        $this->commonInfoParser = new CommonFileParser();
        $this->detailInfoParser = new DetailFileParser();
        $this->carriageListSaver = new CarriageListSaver();
    }
    public function collectDataFromFileList($authorId) {
        $commonCarriageInfo = array();
        $detailCarriageInfo = array();
        $failedParsingFile = array();
        $fileList = $this->getFileListByAuthorId($authorId);
        foreach ($fileList as $file) {
            $fileType = $file->getFileType();
            if ($fileType == FileInfo::COMMON_FILE_TYPE) {
                try {
                    $carriageList = $this->commonInfoParser->collectCommonFileContent($file);
                    //todo сделать обработку дублирования id в списке
                    $commonCarriageInfo = $commonCarriageInfo + $carriageList;
                } catch (\Exception $e) {
                    $failedParsingFile[$file->name] = $e->getMessage();
                }
            } elseif ($fileType == FileInfo::DETAIL_FILE_TYPE) {
                try {
                    $carriage = $this->detailInfoParser->collectDetailFileContent($file);
                    $carriageId = $carriage->id;
                    // todo обработать наличие id в списке
                    $detailCarriageInfo[$carriageId] = $carriage;
                } catch (\Exception $e) {
                    $failedParsingFile[$file->name] = $e->getMessage();
                }
            } else {
                $failedParsingFile[$file->name] = 'Неверный тип файла';
            }
        }
        $result = new Result();
        $result->commonInfo = $commonCarriageInfo;
        $result->detailInfo = $detailCarriageInfo;
        $result->failedParsingFile = $failedParsingFile;
        return $result;
    }

    /**
     * @param $authorId
     * @return FileInfo[]
     */
    protected function getFileListByAuthorId($authorId) {
        return FileInfo::find()->where('author = :author_id', array('author_id' => $authorId))->all();
    }

    public function saveCarriageList($postRequest) {
        if (!isset($postRequest['author_id'])) {
            return;
        }
        $carriageList = $this->collectDataFromFileList($postRequest['author_id']);
        $this->carriageListSaver->save($postRequest, $carriageList);
    }
}