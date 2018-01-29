<?php

class CloudsWidget extends WP_Widget {
    public function __construct() {
        $widget_ops = array(
            'classname' => 'Clouds Widget'
        );
        $control_ops = array(
            'width'     => 300,
            'height'    => 350,
            'id_base'   => 'clouds-widget'
        );
        parent::__construct(
            'clouds-widget',
            'Clouds Widget',
            $widget_ops,
            $control_ops
        );
    }

    public function widget($args, $instance) {
        extract($args);

        isset($instance['link_name'])                               ? $link_name    = \theme\Core::convertTitle($instance['link_name'])    : $link_name    = '';
        isset($instance['link_url'])                                ? $link_url     = $instance['link_url']                         : $link_url     = '';
        (isset($instance['color']) && $instance['color'] != null)   ? $color        = 1                                             : $color        = 0;


        $class = $color ? 'aside__tag aside__tag--red' : 'aside__tag';

        if($link_url)   printf('<a class="%s" href="%s">', $class, $link_url);
        if($link_name)  printf('%s</a>', $link_name);
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['link_name']  = $new_instance['link_name'];
        $instance['link_url']   = $new_instance['link_url'];
        $instance['color']      = $new_instance['color'];
        return $instance;
    }


    public function form($instance) {
        $instance = wp_parse_args($instance); ?>
        <p>
            <label for="<?php echo $this->get_field_id('link_name'); ?>">Link name</label>
            <input id="<?php echo $this->get_field_id('link_name'); ?>" name="<?php echo $this->get_field_name('link_name'); ?>" value="<?= isset($instance['link_name']) ? $instance['link_name'] : '' ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('link_url'); ?>">Link URL</label>
            <input id="<?php echo $this->get_field_id('link_url'); ?>" name="<?php echo $this->get_field_name('link_url'); ?>" value="<?= isset($instance['link_url']) ? $instance['link_url'] : '' ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('color'); ?>">Red?</label>
            <input type="checkbox" name="<?php echo $this->get_field_name('color'); ?>" <?= isset($instance['color']) ? 'checked' : '' ?>>
        </p>
        <?php
    }
}

?>