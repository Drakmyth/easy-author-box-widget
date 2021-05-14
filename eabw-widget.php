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
        $title = empty($title) ? 'Author' : $title;
        $email = get_the_author_meta('user_email');
        $avatar_link = $instance['avatar_link'];
        $avatar_size = $instance['avatar_size'];
        $avatar_shape = $instance['avatar_shape'];
        $avatar_shadow = $instance['avatar_shadow'];
        $avatar_class = '';
        if ($avatar_shape == 'round') {
            $avatar_class .= ' round';
        }
        if ($avatar_shadow) {
            $avatar_class .= ' shadow-avatar';
        }
        $social_links = get_the_author_meta('eabw_social_links');
        $social_shadow = $instance['social_shadow'];
        $social_class = 'widget-social-link';
        if ($social_shadow) {
            $social_class .= ' shadow-social';
        }
        $description = get_the_author_meta('description');

        $background_color = $instance['background_color'];
        $border_color = $instance['border_color'];
        $border_width = $instance['border_width'];
        $border_radius = $instance['border_radius'];
        $body_style = 'background: '.$background_color.'; ';
        $body_style .= 'border-color: '.$border_color.'; ';
        $body_style .= 'border-width: '.$border_width.'px; ';
        $body_style .= 'border-radius: '.$border_radius.'px;';

        $description_color = $instance['description_color'];
        $description_style = 'color: '.$description_color.';';

        echo $args['before_widget'];
        ?>
            <?php echo($args['before_title'].$title.$args['after_title']); ?>
            <div class="widget-body" style="<?php echo($body_style); ?>">
                <?php $this->output_author_name($instance); ?>
                <?php echo(get_avatar($email, $avatar_size, '', '', array('class'=>$avatar_class))); ?>
                <div class="widget-social">
                    <?php foreach($social_links as $link) { ?>
                        <a href="<?php echo($link[3]); ?>" class="<?php echo($social_class); ?>" title="<?php echo($link[2]); ?>">
                        <i class="fab fa-<?php echo($link[0]); ?> color"></i>
                    </a>
                    <?php } ?>
                </div>
                <p style="<?php echo($description_style); ?>"><?php echo($description); ?></p>
            </div>
        <?php
        echo $args['after_widget'];
    }

    private function output_author_name($instance) {
        $author_id = get_the_author_meta('ID');
        $display_name = get_the_author_meta('display_name');
        $name_link = $instance['name_link'];
        $website = get_the_author_meta('user_url');
        $website_override = get_the_author_meta('eabw_website_override');
        $posts_url = get_author_posts_url($author_id);
        $name_style = 'color: '.$instance['name_color'].';';
        
        switch($name_link) {
            case 'posts':
                $author_url = $posts_url;
                break;
            case 'website':
                if (!empty($website)) {
                    $author_url = $website;
                }
                break;
            case 'override':
                if (!empty($website_override)) {
                    $author_url = $website_override;
                }
                break;
        }
        
        if (isset($author_url)) { ?>
            <a href="<?php echo($author_url); ?>">
                <span style="<?php echo($name_style); ?>"><?php echo($display_name); ?></span>
            </a>
        <?php } else { ?>
            <span style="<?php echo($name_style); ?>"><?php echo($display_name); ?></span>
        <?php }
    }

    /**
     * Back-end widget form
     * 
     * @see WP_Widget::form()
     * 
     * @param array $instance Previously saved values from database
     */
    public function form($instance) {
        $title = esc_attr(! empty($instance['title']) ? $instance['title'] : '');
        $title_id = $this->get_field_id('title');
        $title_name = $this->get_field_name('title');

        $name_link = esc_attr(! empty($instance['name_link']) ? $instance['name_link'] : 'posts');
        $name_link_id = $this->get_field_id('name_link');
        $name_link_name = $this->get_field_name('name_link');

        $avatar_link = esc_attr(! empty($instance['avatar_link']) ? $instance['avatar_link'] : 'none');
        $avatar_link_id = $this->get_field_id('avatar_link');
        $avatar_link_name = $this->get_field_name('avatar_link');

        $avatar_size = esc_attr(is_numeric($instance['avatar_size']) ? $instance['avatar_size'] : 150);
        $avatar_size_id = $this->get_field_id('avatar_size');
        $avatar_size_name = $this->get_field_name('avatar_size');

        $avatar_shape = esc_attr(! empty($instance['avatar_shape']) ? $instance['avatar_shape'] : 'square');
        $avatar_shape_id = $this->get_field_id('avatar_shape');
        $avatar_shape_name = $this->get_field_name('avatar_shape');

        $avatar_shadow = esc_attr(! empty($instance['avatar_shadow']) ? $instance['avatar_shadow'] : false);
        $avatar_shadow_id = $this->get_field_id('avatar_shadow');
        $avatar_shadow_name = $this->get_field_name('avatar_shadow');

        $social_shadow = esc_attr(! empty($instance['social_shadow']) ? $instance['social_shadow'] : false);
        $social_shadow_id = $this->get_field_id('social_shadow');
        $social_shadow_name = $this->get_field_name('social_shadow');

        $background_color = esc_attr(! empty($instance['background_color']) ? $instance['background_color'] : '#ffffff');
        $background_color_id = $this->get_field_id('background_color');
        $background_color_name = $this->get_field_name('background_color');

        $name_color = esc_attr(! empty($instance['name_color']) ? $instance['name_color'] : '#000000');
        $name_color_id = $this->get_field_id('name_color');
        $name_color_name = $this->get_field_name('name_color');

        $description_color = esc_attr(! empty($instance['description_color']) ? $instance['description_color'] : '#000000');
        $description_color_id = $this->get_field_id('description_color');
        $description_color_name = $this->get_field_name('description_color');
        
        $border_color = esc_attr(! empty($instance['border_color']) ? $instance['border_color'] : '#000000');
        $border_color_id = $this->get_field_id('border_color');
        $border_color_name = $this->get_field_name('border_color');

        $border_width = esc_attr(is_numeric($instance['border_width']) ? $instance['border_width'] : 3);
        $border_width_id = $this->get_field_id('border_width');
        $border_width_name = $this->get_field_name('border_width');

        $border_radius = esc_attr(is_numeric($instance['border_radius']) ? $instance['border_radius'] : 0);
        $border_radius_id = $this->get_field_id('border_radius');
        $border_radius_name = $this->get_field_name('border_radius');
        ?>

        <p>
            <label for="<?php echo($title_id); ?>">Title:</label>
            <input type="text" class="widefat" id="<?php echo($title_id); ?>" name="<?php echo($title_name); ?>" value="<?php echo($title); ?>" />
        </p>
        <p>
            <label for="<?php echo($name_link_id); ?>">Name Link:</label>
            <select id="<?php echo($name_link_id); ?>" name="<?php echo($name_link_name); ?>">
                <option value="none" <?php if($name_link == 'none') { echo('selected'); } ?>>None</option>
                <option value="posts" <?php if($name_link == 'posts') { echo('selected'); } ?>>Posts</option>
                <option value="website" <?php if($name_link == 'website') { echo('selected'); } ?>>Website</option>
                <option value="override" <?php if($name_link == 'override') { echo('selected'); } ?>>Override</option>
            </select>
        </p>
        <p>
            <label for="<?php echo($avatar_link_id); ?>">Avatar Link:</label>
            <select id="<?php echo($avatar_link_id); ?>" name="<?php echo($avatar_link_name); ?>">
                <option value="none" <?php if($avatar_link == 'none') { echo('selected'); } ?>>None</option>
                <option value="posts" <?php if($avatar_link == 'posts') { echo('selected'); } ?>>Posts</option>
                <option value="website" <?php if($avatar_link == 'website') { echo('selected'); } ?>>Website</option>
                <option value="override" <?php if($avatar_link == 'override') { echo('selected'); } ?>>Override</option>
            </select>
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
        <p>
            <input type="checkbox" id="<?php echo($avatar_shadow_id); ?>" name="<?php echo($avatar_shadow_name); ?>" value="value" <?php if($avatar_shadow) { echo('checked'); } ?>/>
            <label for="<?php echo($avatar_shadow_id); ?>">Show shadow on avatar?</label>
        </p>
        <p>
            <input type="checkbox" id="<?php echo($social_shadow_id); ?>" name="<?php echo($social_shadow_name); ?>" value="value" <?php if($social_shadow) { echo('checked'); } ?>/>
            <label for="<?php echo($social_shadow_id); ?>">Show shadow on social icons?</label>
        </p>
        <p>
            <label for="<?php echo($background_color_id); ?>">Background Color:</label>
            <input type="color" id="<?php echo($background_color_id); ?>" name="<?php echo($background_color_name); ?>" value="<?php echo($background_color); ?>" />
        </p>
        <p>
            <label for="<?php echo($name_color_id); ?>">Name Color:</label>
            <input type="color" id="<?php echo($name_color_id); ?>" name="<?php echo($name_color_name); ?>" value="<?php echo($name_color); ?>" />
        </p>
        <p>
            <label for="<?php echo($description_color_id); ?>">Description Color:</label>
            <input type="color" id="<?php echo($description_color_id); ?>" name="<?php echo($description_color_name); ?>" value="<?php echo($description_color); ?>" />
        </p>
        <p>
            <label for="<?php echo($border_color_id); ?>">Border Color:</label>
            <input type="color" id="<?php echo($border_color_id); ?>" name="<?php echo($border_color_name); ?>" value="<?php echo($border_color); ?>" />
        </p>
        <p>
            <label for="<?php echo($border_width_id); ?>">Border Width:</label>
            <input type="range" min="0" max="30" class="slider widefat" id="<?php echo($border_width_id); ?>" name="<?php echo($border_width_name); ?>" value="<?php echo($border_width); ?>" />
            <span id="<?php echo($border_width_id.'_display'); ?>"></span>
        </p>
        <p>
            <label for="<?php echo($border_radius_id); ?>">Border Radius:</label>
            <input type="range" min="0" max="100" class="slider widefat" id="<?php echo($border_radius_id); ?>" name="<?php echo($border_radius_name); ?>" value="<?php echo($border_radius); ?>" />
            <span id="<?php echo($border_radius_id.'_display'); ?>"></span>
        </p>

        <?php
            $sliderIds = implode("', '", array($avatar_size_id, $border_width_id, $border_radius_id));
        ?>
        
        <script>
            var sliderIds = ['<?php echo($sliderIds); ?>'];
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
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['name_link'] = sanitize_key($new_instance['name_link']);
        $instance['avatar_link'] = sanitize_key($new_instance['avatar_link']);
        $instance['avatar_size'] = is_numeric($new_instance['avatar_size']) ? $new_instance['avatar_size'] : 150;
        $instance['avatar_shape'] = sanitize_key($new_instance['avatar_shape']);
        $instance['avatar_shadow'] = isset($new_instance['avatar_shadow']);
        $instance['social_shadow'] = isset($new_instance['social_shadow']);
        $instance['background_color'] = sanitize_hex_color($new_instance['background_color']);
        $instance['name_color'] = sanitize_hex_color($new_instance['name_color']);
        $instance['description_color'] = sanitize_hex_color($new_instance['description_color']);
        $instance['border_color'] = sanitize_hex_color($new_instance['border_color']);
        $instance['border_width'] = is_numeric($new_instance['border_width']) ? $new_instance['border_width'] : 3;
        $instance['border_radius'] = is_numeric($new_instance['border_radius']) ? $new_instance['border_radius'] : 0;
        return $instance;
    }
}

?>