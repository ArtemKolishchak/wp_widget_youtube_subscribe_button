<?php
/**
 * Adds Youtube_Subscribe_Button widget.
 */
class Youtube_Subscribe_Button extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'youtube_subscribe_button', // Base ID
			esc_html__( 'Youtube Subscribe Button', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Youtube Subscribe Button', 'text_domain' ), ) // Args
        );
        add_action('wp_enqueue_scripts', array($this, 'register_widget_script'));
    }
    
    public function register_widget_script() {
        wp_register_script('youtube_subscribe_button', 'https://apis.google.com/js/platform.js');
        wp_enqueue_script('youtube_subscribe_button');
    }

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
        echo 
            '<div class="g-ytsubscribe" 
                    data-channel="' . $instance['channel'] . '" 
                    data-layout="' . $instance['layout'] . '" 
                    data-theme="' . $instance['theme'] . '"
                    data-count="' . $instance['count'] . '"
            >
            </div>';
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );

        $channel = ! empty( $instance['channel'] ) ? $instance['channel'] : esc_html__( '', 'text_domain' );

        $layout = ! empty( $instance['layout'] ) ? $instance['layout'] : esc_html__( 'default', 'text_domain' );

        $theme = ! empty( $instance['theme'] ) ? $instance['theme'] : esc_html__( 'default', 'text_domain' );

        $count = ! empty( $instance['count'] ) ? $instance['count'] : esc_html__( 'default', 'text_domain' );

		?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?>
                </label> 
                <input class="widefat" 
                    id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
                    name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
                    type="text" 
                    value="<?php echo esc_attr( $title ); ?>"
                >
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'channel' ) ); ?>"><?php esc_attr_e( 'Channel Name:', 'text_domain' ); ?>
                </label> 
                <input class="widefat" 
                    id="<?php echo esc_attr( $this->get_field_id( 'channel' ) ); ?>" 
                    name="<?php echo esc_attr( $this->get_field_name( 'channel' ) ); ?>" 
                    type="text" 
                    value="<?php echo esc_attr( $channel ); ?>"
                >
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_attr_e( 'Layout:', 'text_domain' ); ?>
                </label> 
                <select class="widefat" 
                    id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" 
                    name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" 
                >
                <option value="default" <?php echo ($layout == 'default') ? 'selected' : ''; ?>>default</option>
                <option value="full" <?php echo ($layout == 'full') ? 'selected' : ''; ?>>full</option>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'theme' ) ); ?>"><?php esc_attr_e( 'Theme:', 'text_domain' ); ?>
                </label> 
                <select class="widefat" 
                    id="<?php echo esc_attr( $this->get_field_id( 'theme' ) ); ?>" 
                    name="<?php echo esc_attr( $this->get_field_name( 'theme' ) ); ?>" 
                >
                <option value="default" <?php echo ($theme == 'default') ? 'selected' : ''; ?>>default</option>
                <option value="dark" <?php echo ($theme == 'dark') ? 'selected' : ''; ?>>dark</option>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_attr_e( 'Subscriber count:', 'text_domain' ); ?>
                </label> 
                <select class="widefat" 
                    id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" 
                    name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" 
                >
                <option value="default" <?php echo ($count == 'default') ? 'selected' : ''; ?>>default(show)</option>
                <option value="hidden" <?php echo ($count == 'hidden') ? 'selected' : ''; ?>>hidden</option>
                </select>
            </p>

		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
        $instance = array();
        
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        $instance['channel'] = ( ! empty( $new_instance['channel'] ) ) ? sanitize_text_field( $new_instance['channel'] ) : '';

        $instance['layout'] = ( ! empty( $new_instance['layout'] ) ) ? sanitize_text_field( $new_instance['layout'] ) : '';

        $instance['theme'] = ( ! empty( $new_instance['theme'] ) ) ? sanitize_text_field( $new_instance['theme'] ) : '';

        $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? sanitize_text_field( $new_instance['count'] ) : '';

		return $instance;
	}

} // class Youtube_Subscribe_Button

// register Youtube_Subscribe_Button widget
function register_youtube_subscribe_button() {
    register_widget( 'Youtube_Subscribe_Button' );
}
add_action( 'widgets_init', 'register_youtube_subscribe_button' );