<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 21.03.15
 * Time: 17:11
 */

namespace app\models;


class LogProvider {
    /** @var self */
    protected static $self;
    protected $carriageId;

    protected function __construct() {}

    public static function instance() {
        if (empty(self::$self)) {
            self::$self = new self();
        }
        return self::$self;
    }

    public function setContext($carriageId) {
        $this->carriageId = $carriageId;
        return self::$self;
    }

    public function save($message) {
        $log = new Log();
        $log->carriage_id = $this->carriageId;
        $log->message = $message;
        $log->save();
    }
}