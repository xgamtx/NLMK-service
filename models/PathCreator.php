<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 02.03.15
 * Time: 9:38
 */

namespace app\models;


class PathCreator {

    public static function createPath($path) {
        $partList = explode('/', $path);
        $fullPath = '';
        foreach ($partList as $currentPath) {
            if (!empty($fullPath)) {
                $fullPath .= "/";
            }
            $fullPath .= $currentPath;
            if (!file_exists($fullPath)) {
                mkdir($fullPath);
            }
        }
    }
}