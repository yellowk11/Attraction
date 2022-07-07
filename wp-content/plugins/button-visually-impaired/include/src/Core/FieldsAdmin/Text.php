<?php
/**
 * Field text class.
 *
 * @package Bvi\Core\Fields
 * @since   1.0.0
 */

namespace Bvi\Core\FieldsAdmin;

if ( ! class_exists( 'Text' ) ) {

	/**
	 * Class Text
	 * @package Bvi\Core\FieldsAdmin
	 */
	class Text extends Fields {

		/**
		 * Defaults.
		 *
		 * @return array
		 */
		public function defaults(): array {
			return [
				'key'         => '',
				'label_for'   => '',
				'description' => '',
				'name'        => '',
				'max'         => '',
				'min'         => '',
				'maxlength'   => '',
				'step'        => '',
				'placeholder' => '',
				'required'    => '',
				'size'        => '',
				'class'       => '',
			];
		}

		/**
		 * Renders the HTML content.
		 *
		 * @param array $args
		 *
		 * @return mixed|void
		 */
		public function render( array $args ) {
			$wp_parse_args = (object) wp_parse_args( $args, $this->defaults() );
			$option        = $this->getOption();

			echo sprintf(
				'<input type="text" name="%1$s" value="%2$s" id="%3$s" class="regular-text code">',
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
