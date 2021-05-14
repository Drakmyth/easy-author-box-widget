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
        $title = apply_filters('widget_title', $instance['title']);
        $display_name = get_the_author_meta('display_name');
        $email = get_the_author_meta('user_email');
        $avatar_size = $instance['avatar_size'];
        $avatar_shape = $instance['avatar_shape'];
        // $avatar_shadow = $instance['avatar_shadow'];
        $avatar_class = '';
        if ($avatar_shape == 'round') {
            $avatar_class .= ' round';
        }
        $social_links = get_the_author_meta('eabw_social_links');
        // $social_shadow = $instance['social_shadow'];
        $social_class = 'widget-social-link shadow-social';
        $description = get_the_author_meta('description');

        echo $args['before_widget'];
        ?>
            <?php echo($args['before_title'].$title.$args['after_title']); ?>
            <div class="widget-body">
                <span><?php echo($display_name); ?></span>
                <?php echo(get_avatar($email, $avatar_size, '', '', array('class'=>$avatar_class))); ?>
                <div class="widget-social">
                    <?php foreach($social_links as $link) { ?>
                        <a href="<?php echo($link[3]); ?>" class="<?php echo($social_class); ?>" title="<?php echo($link[2]); ?>">
                        <i class="fab fa-<?php echo($link[0]); ?> color"></i>
                    </a>
                    <?php } ?>
                </div>
                <p><?php echo($description); ?></p>
            </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form
     * 
     * @see WP_Widget::form()
     * 
     * @param array $instance Previously saved values from database
     */
    public function form($instance) {
        $title = esc_attr(! empty($instance['title']) ? $instance['title'] : 'Author');
        $title_id = $this->get_field_id('title');
        $title_name = $this->get_field_name('title');

        $avatar_size = esc_attr(! empty($instance['avatar_size']) ? $instance['avatar_size'] : 150);
        $avatar_size_id = $this->get_field_id('avatar_size');
        $avatar_size_name = $this->get_field_name('avatar_size');

        $avatar_shape = esc_attr(! empty($instance['avatar_shape']) ? $instance['avatar_shape'] : 'square');
        $avatar_shape_id = $this->get_field_id('avatar_shape');
        $avatar_shape_name = $this->get_field_name('avatar_shape');

        // $avatar_shadow esc_attr(! empty($instance['avatar_shadow']) ? $instance['avatar_shadow'] : false);
        // $avatar_shadow_id = $this->get_field_id('avatar_shadow');
        // $avatar_shadow_name = $this->get_field_name('avatar_shadow');

        // $social_shadow esc_attr(! empty($instance['social_shadow']) ? $instance['social_shadow'] : false);
        // $social_shadow_id = $this->get_field_id('social_shadow');
        // $social_shadow_name = $this->get_field_name('social_shadow');

        // $border_width esc_attr(! empty($instance['border_width']) ? $instance['border_width'] : '');
        // $border_width_id = $this->get_field_id('border_width');
        // $border_width_name = $this->get_field_name('border_width');

        // $border_color esc_attr(! empty($instance['border_color']) ? $instance['border_color'] : '');
        // $border_color_id = $this->get_field_id('border_color');
        // $border_color_name = $this->get_field_name('border_color');

        // $border_radius esc_attr(! empty($instance['border_radius']) ? $instance['border_radius'] : '');
        // $border_radius_id = $this->get_field_id('border_radius');
        // $border_radius_name = $this->get_field_name('border_radius');

        // $background_color esc_attr(! empty($instance['background_color']) ? $instance['background_color'] : '');
        // $background_color_id = $this->get_field_id('background_color');
        // $background_color_name = $this->get_field_name('background_color');
        ?>

        <p>
            <label for="<?php echo($title_id); ?>">Title:</label>
            <input type="text" class="widefat" id="<?php echo($title_id); ?>" name="<?php echo($title_name); ?>" value="<?php echo($title); ?>" />
        </p>
        <p>
            <label for="<?php echo($avatar_size_id); ?>">Avatar Size:</label>
            <input type="range" min="100" max="200" class="slider widefat" id="<?php echo($avatar_size_id); ?>" name="<?php echo($avatar_size_name); ?>" value="<?php echo($avatar_size); ?>" />
            <span id="<?php echo($avatar_size_id.'_display'); ?>"></span>
        </p>
        <p>
            <label for="<?php echo($avatar_shape_id); ?>">Avatar Shape:</label>
            <select id="<?php echo($avatar_shape_id); ?>" name="<?php echo($avatar_shape_name); ?>">
                <option value="square" <?php if($avatar_shape == 'square') { echo('selected'); } ?>>Square</option>
                <option value="round" <?php if($avatar_shape == 'round') { echo('selected'); } ?>>Round</option>
            </select>
        </p>
        
        <script>
            var sliderIds = ['<?php echo($avatar_size_id); ?>'];
            sliderIds.forEach(sliderId => {
                var slider = document.getElementById(sliderId);
                var display = document.getElementById(sliderId + "_display");
                display.innerHTML = slider.value;

                slider.oninput = function() {
                    display.innerHTML = this.value;
                }
            });
        </script>

        <?php
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
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['avatar_size'] = $new_instance['avatar_size'];
        $instance['avatar_shape'] = strip_tags($new_instance['avatar_shape']);
        return $instance;
    }
}

?>