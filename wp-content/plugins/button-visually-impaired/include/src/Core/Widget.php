<?php
/**
 * Widget class.
 *
 * @package Bvi
 * @since   1.0.0
 */

namespace Bvi\Core;

if ( ! class_exists( 'Widget' ) ) {

	/**
	 * Class Widget
	 * @package Bvi\Core
	 */
	class Widget extends \WP_Widget {

		/**
		 * @var Core
		 */
		public Core $core;

		/**
		 * @var array|bool
		 */
		public $option;

		/**
		 * Widget constructor.
		 */
		public function __construct() {
			parent::__construct( 'Bvi_Widget', 'Button visually impaired' );
			$this->core   = new Core();
			$this->option = $this->core->getOption();
		}

		/**
		 * Echoes the widget content.
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			$title                   = apply_filters( 'widget_title', $instance['title'] );
			$instance['bviLinkText'] = ( ! empty( $new_instance['bviLinkText'] ) ) ? strip_tags( $new_instance['bviLinkText'] ) : strip_tags( $this->option['bviLinkText'] );

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			$svgEye = '<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="bvi-svg-eye"><path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z" class="bvi-svg-eye"></path></svg>';


			echo '<div class="bvi-widget"><a href="#" class="bvi-open">' . $svgEye . '&ensp;' . $instance['bviLinkText'] . '</a></div>';

			echo $args['after_widget'];
		}

		/**
		 * Updates a particular instance of a widget.
		 *
		 * @param array $new_instance
		 * @param array $old_instance
		 *
		 * @return array|void
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                    = [];
			$instance['title']           = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['bviLinkText']     = ( ! empty( $new_instance['bviLinkText'] ) ) ? strip_tags( $new_instance['bviLinkText'] ) : strip_tags( $this->option['bviLinkText'] );
			$this->option['bviLinkText'] = esc_attr( $instance['bviLinkText'] );

			update_option( $this->core->pluginOptionName, $this->option );

			return $instance;
		}

		/**
		 * Outputs the settings update form.
		 *
		 * @param array $instance
		 *
		 * @return string|void
		 */
		public function form( $instance ) {
			$title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$bviLinkText = ! empty( $instance['bviLinkText'] ) ? $instance['bviLinkText'] : $this->option['bviLinkText'];

			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Заголовок:</label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $title ); ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'bviLinkText' ) ); ?>">Текс ссылки:</label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'bviLinkText' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $bviLinkText ); ?>">
            </p>
            <p><a href="<?php echo get_admin_url( false, 'admin.php?page=bvi#bviLinkColor' ); ?>"
                  class="page-title-action">Изменить цвет ссылки</a></p>
			<?php
		}
	}
}
