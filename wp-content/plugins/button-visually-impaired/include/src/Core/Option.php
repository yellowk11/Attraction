<?php
/**
 * Option class.
 *
 * @package Bvi\Core
 * @since   1.0.0
 */

namespace Bvi\Core;

if ( ! class_exists( 'Option' ) ) {

	/**
	 * Class Option
	 * @package Bvi\Core
	 */
	class Option {

		/**
		 * Plugin instance.
		 */
		protected static ?Option $instance = null;

		/**
		 * Access this plugin’s working instance
		 *
		 * @return Option
		 */
		public static function getInstance(): ?Option {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Default option.
		 */
		public function options(): array {
			return [
				'bviActive'         => 'false',
				'bviScriptLocation' => 'false',
				'bviTheme'          => 'white',
				'bviFont'           => 'arial',
				'bviFontSize'       => '16',
				'bviLetterSpacing'  => 'normal',
				'bviLineHeight'     => 'normal',
				'bviImages'         => 'true',
				'bviReload'         => 'false',
				'bviSpeech'         => 'true',
				'bviBuiltElements'  => 'true',
				'bviPanelHide'      => 'false',
				'bviPanelFixed'     => 'true',
				'bviLang'           => 'ru-RU',
				'bviLinkText'       => 'Версия сайта для слабовидящих',
				'bviLinkColor'      => '#ffffff',
				'bviLinkBg'         => '#e53935',
			];
		}
	}
}