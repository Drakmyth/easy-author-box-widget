<?php
/**
 * Easy Author Box Widget
 *
 * @author            Shaun Hamman
 * @copyright         Copyright (c) 2021, Shaun Hamman
 * @license           GPL-2.0-or-later
 */

/**
 * Widget class
 */
class EABW_Widget extends WP_Widget {
    /**
     * Register widget with wordpress
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'eabw_widget',
            'description' => 'description goes here'
        );
        parent::__construct( 'eabw_widget', 'Easy Author Box', $widget_ops );
    }

    /**
     * Front-end display of widget
     * 
     * @see WP_Widget::widget()
     * 
     * @param array $args     Widget arguments
     * @param array $instance Saved values from database
     */
    public function widget($args, $instance) {
        $author = get_the_author();
        ?>
            <div class="widget widget_eabw">
                <h3 class="widget-title">Author</h3>
                <span><?php echo($author); ?></span>
            </div>
        <?php
    }

    /**
     * Back-end widget form
     * 
     * @see WP_Widget::form()
     * 
     * @param array $instance Previously saved values from database
     */
    public function form($instance) {

    }

    /**
     * Sanitize widget form values as they are saved
     * 
     * @see WP_Widget::update()
     * 
     * @param array $new_instance Values just sent to be saved
     * @param array $old_instance Previously saved values from database
     * 
     * @return array Updated safe values to be saved
     */
    public function update($new_instance, $old_instance) {

    }
}

?>