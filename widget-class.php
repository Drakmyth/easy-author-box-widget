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
        $display_name = get_the_author_meta('display_name');
        $email = get_the_author_meta('user_email');
        $description = get_the_author_meta('description');
        $social_links = get_the_author_meta('eabw_social_links');
        $social_class = 'widget-social-link shadow-social';
        $avatar_class = 'shadow-avatar round';
        ?>
            <div class="widget eabw-widget">
                <h3 class="widget-title">Author</h3>
                <div class="widget-body">
                    <span><?php echo($display_name); ?></span>
                    <?php echo(get_avatar($email, 150, '', '', array('class'=>$avatar_class))); ?>
                    <div class="widget-social">
                        <?php foreach($social_links as $link) { ?>
                            <a href="<?php echo($link[3]); ?>" class="<?php echo($social_class); ?>" title="<?php echo($link[2]); ?>">
                            <i class="fab fa-<?php echo($link[0]); ?> color"></i>
                        </a>
                        <?php } ?>
                    </div>
                    <p><?php echo($description); ?></p>
                </div>
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