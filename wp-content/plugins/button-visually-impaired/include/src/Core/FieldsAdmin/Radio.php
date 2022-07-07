<?php
/**
 * Field radio class.
 *
 * @package Bvi\Core\FieldsAdmin
 * @since   1.0.0
 */

namespace Bvi\Core\FieldsAdmin;

if ( ! class_exists( 'Radio' ) ) {

	/**
	 * Class Radio
	 * @package Bvi\Core\FieldsAdmin
	 */
	class Radio extends Fields {

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

			if ( is_array( $wp_parse_args->value ) ) {
				echo '<fieldset>';

				foreach ( $wp_parse_args->value as $key => $value ) {
					$checked = checked( $key, $option[ $wp_parse_args->name ], false );
					echo sprintf(
						'<label id="%5$s"><input type="radio" name="%4$s" value="%1$s" %3$s>%2$s</label> ',
						esc_attr( $key ),
						esc_attr( $value ),
						$checked,
						esc_attr( $this->pluginOptionName . "[$wp_parse_args->name]" ),
						esc_attr( $wp_parse_args->label_for )
					);
				}

				echo '</fieldset>';
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
