<?php

namespace theme;

class Icon {
    static private $name;
    static public function get_icon($name) {
        self::$name = $name;

        return sprintf('<svg><use xlink:href="%s/assets/img/sprite.svg#ico-%s"></use></svg>',
            get_template_directory_uri(),
            self::$name
        );
    }
}