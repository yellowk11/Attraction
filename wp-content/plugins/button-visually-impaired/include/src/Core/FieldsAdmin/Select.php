<?php
/**
 * Field select class.
 *
 * @package Bvi\Core\FieldsAdmin
 * @since   1.0.0
 */

namespace Bvi\Core\FieldsAdmin;

if ( ! class_exists( 'Select' ) ) {

	/**
	 * Class Select
	 * @package Bvi\Core\FieldsAdmin
	 */
	class Select extends Fields {

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
				'accesskey'   => '',
				'autofocus'   => '',
				'disabled'    => '',
				'form'        => '',
				'multiple'    => '',
				'required'    => '',
				'size'        => '',
				'class'       => '',
				'tabindex'    => '',
				'value'       => ''
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

			if ( is_array( $wp_parse_args->value ) ) {
				echo sprintf(
					'<select name="%1$s" id="%2$s">',
					esc_attr( $this->pluginOptionName . "[$wp_parse_args->name]" ),
					esc_attr( $wp_parse_args->label_for )
				);

				foreach ( $wp_parse_args->value as $key => $value ) {
					$selected = selected( $key, $option[ $wp_parse_args->name ], false );
					echo sprintf(
						'<option value="%1$s" %3$s>%2$s</option>',
						esc_attr( $key ),
						esc_html( $value ),
						$selected
					);
				}

				echo '</select>';
			}

			if ( ! empty( $wp_parse_args->description ) ) {
				echo sprintf(
					'<p class="description">%s</p>',
					esc_html( $wp_parse_args->description )
				);
			}
		}
	}
}
