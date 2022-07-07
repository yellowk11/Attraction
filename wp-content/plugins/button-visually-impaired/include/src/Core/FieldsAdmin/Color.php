<?php
/**
 * Field color class.
 *
 * @package Bvi\Core\FieldsAdmin
 * @since   1.0.0
 */

namespace Bvi\Core\FieldsAdmin;

if ( ! class_exists( 'Color' ) ) {

	/**
	 * Class Radio
	 * @package Bvi\Core\FieldsAdmin
	 */
	class Color extends Fields {

		/**
		 * Defaults.
		 *
		 * @return array
		 */
		public function defaults(): array {
			return [
				'label_for'   => '',
				'description' => '',
				'name'        => '',
				'value'       => '',
			];
		}

		/**
		 * Renders the HTML content.
		 *
		 * @param array $args
		 *
		 * @return void
		 */
		public function render( array $args ) {
			$wp_parse_args = (object) wp_parse_args( $args, $this->defaults() );
			$option        = $this->getOption();

			echo sprintf(
				'<input type="color" name="%1$s" value="%2$s" id="%3$s">',
				esc_attr( $this->pluginOptionName . "[$wp_parse_args->name]" ),
				esc_attr( $option[ $wp_parse_args->name ] ),
				esc_html( $wp_parse_args->label_for )
			);

			if ( ! empty( $wp_parse_args->description ) ) {
				echo sprintf(
					'<p class="description">%s</p>',
					esc_html( $wp_parse_args->description )
				);
			}
		}
	}
}
