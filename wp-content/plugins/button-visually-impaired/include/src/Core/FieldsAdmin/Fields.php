<?php
/**
 * Fields abstract class.
 *
 * @package Bvi\Core\FieldsAdmin
 * @since   1.0.0
 */

namespace Bvi\Core\FieldsAdmin;

use Bvi\Core\Core;

if ( ! class_exists( 'Fields' ) ) {

	/**
	 * Class Fields
	 * @package Bvi\Core\FieldsAdmin
	 */
	abstract class Fields extends Core {

		/**
		 * Defaults value.
		 *
		 * @return array
		 */
		abstract function defaults(): array;

		/**
		 * Renders the HTML content.
		 *
		 * @param array $args
		 *
		 * @return mixed
		 */
		abstract function render( array $args );
	}
}
