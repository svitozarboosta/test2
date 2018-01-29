<?php

class OurServicesWidget extends WP_Widget {
    public function __construct() {
        $widget_ops = array(
            'classname' => 'Our Services Widget'
        );
        $control_ops = array(
            'width'     => 300,
            'height'    => 350,
            'id_base'   => 'our_services-widget'
        );
        parent::__construct(
            'our_services-widget',
            'Our Services Widget',
            $widget_ops,
            $control_ops
        );
    }

    public function widget($args, $instance) {
        extract($args);

        isset($instance['text'])    ? $text     = $instance['text']                                 : $text     = '';
        isset($instance['title'])   ? $title    = \theme\Core::convertTitle($instance['title'])     : $title    = '';
        isset($instance['url'])     ? $url      = $instance['url']                                  : $url      = '';

        echo $before_widget;
        echo !empty($url)   ? "<a href='{$url}'>"                               : '';
        echo !empty($title) ? "<h3 class='services__title'>{$title}</h3>"     : '';
        echo !empty($text)  ? "<div class='services__text'>{$text}</div>"       : '';
        echo !empty($url)   ? '</a>'                                            : '';
        echo $after_widget;
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title']  = $new_instance['title'];
        $instance['text']   = $new_instance['text'];
        $instance['url']    = $new_instance['url'];
        return $instance;
    }


    public function form($instance) {
        $instance = wp_parse_args($instance);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?= isset($instance['title']) ? $instance['title'] : '' ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>">Text:</label>
            <textarea id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" style="width:100%;" ><?= isset($instance['text']) ? $instance['text'] : '' ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('url'); ?>">Url:</label>
            <input id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?= isset($instance['url']) ? $instance['url'] : '' ?>" style="width:100%;" />
        </p>
        <?php
    }
}

?>