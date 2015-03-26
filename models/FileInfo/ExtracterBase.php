<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 21.03.15
 * Time: 20:57
 */

namespace app\models\FileInfo;


class ExtracterBase {

    const MAX_USEFUL_COLUMN_ID = 15;

    protected function getColumnCode($columnId) {
        $currentColumnId = $columnId;
        $countSymbol = ord('Z') - ord('A') + 1;
        $result = '';
        while ($currentColumnId > 0) {
            $ost = $currentColumnId % ($countSymbol);
            $currentColumnId = ($currentColumnId - $ost) / $countSymbol;
            $result = chr(ord('A') + $ost - 1) . $result;
        }
        return $result;
    }

}