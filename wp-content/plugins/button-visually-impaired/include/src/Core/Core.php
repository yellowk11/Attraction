<?php
/**
 * Core class.
 *
 * @package Bvi\Core
 * @since   1.0.0
 */

namespace Bvi\Core;

if ( ! class_exists( 'Core' ) ) {

	/**
	 * Class Core
	 * @package Bvi\Core
	 */
	class Core {

		/**
		 * @var string
		 */
		public string $pluginOptionName = 'bvi-option';

		/**
		 * @var string
		 */
		public string $pluginName = 'Button visually impaired';

		/**
		 * @var string
		 */
		public string $pluginNameShort = 'BVI';

		/**
		 * @var string
		 */
		public string $pluginMenuSlug = 'bvi';

		/**
		 * @var string
		 */
		public string $pluginOptionGroup = 'bvi-option-group';

		/**
		 * @var string
		 */
		public string $pluginSettingsSection = 'bvi-settings-section';

		/**
		 * @var array|false|mixed|void
		 */
		protected $pluginSetOption;

		/**
		 * Get value settings options.
		 *
		 * @return bool|array
		 */
		public function getOption() {
			return get_option( $this->pluginOptionName );
		}

		/**
		 * Set value settings options.
		 *
		 * @param $option
		 *
		 * @return $this
		 */
		public function setOption( $option ): Core {
			$this->pluginSetOption = $option;

			return $this;
		}

		/**
		 * Register option.
		 */
		public function registerOption() {
			if ( false === $this->getOption() ) {
				add_option( $this->pluginOptionName, $this->pluginSetOption );
			} else {
				update_option( $this->pluginOptionName, $this->pluginSetOption );
			}
		}
	}
}
