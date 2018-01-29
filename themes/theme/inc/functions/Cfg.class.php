<?php

namespace theme;


class Cfg {

    private static $cfg;

    public static function setConfig(array $cfg) {
        self::$cfg = $cfg;
    }

    public static function getConfig($name) {
        return isset(self::$cfg[$name]) ? self::$cfg[$name] : false;
    }

}