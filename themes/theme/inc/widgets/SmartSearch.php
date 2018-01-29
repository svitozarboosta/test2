<?php

class SmartSearchWidget extends WP_Widget {

    public $count = 1;

    public function __construct() {
        $widget_ops = array(
            'classname' => 'Smart Search Widget'
        );
        $control_ops = array(
            'width'     => 300,
            'height'    => 350,
            'id_base'   => 'smart_search-widget'
        );
        parent::__construct(
            'smart_search-widget',
            'Smart Search Widget',
            $widget_ops,
            $control_ops
        );
    }

    public function widget($args, $instance) {
        extract($args);

        isset($instance['text'])    ? $text     = $instance['text']     : $text     = '';
        isset($instance['title'])   ? $title    = $instance['title']    : $title    = '';

        echo $before_widget;
        echo "<div class='steps__number'>{$this->count}</div>";
        echo !empty($title) ? "<div class='steps__title'>{$title}</div>"   : '';
        echo !empty($text)  ? "<div class='steps__text'>{$text}</div>"     : '';
        echo $after_widget;

        $this->count++;
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title']  = $new_instance['title'];
        $instance['text']   = $new_instance['text'];
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
        <?php
    }
}