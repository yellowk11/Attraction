<?php
/**
 * Activate class.
 *
 * @package Bvi\Core
 * @since   1.0.0
 */

namespace Bvi\Core;

if ( ! class_exists( 'Activate' ) ) {

	/**
	 * Class Activate
	 * @package Bvi\Core
	 */
	class Activate extends Core {

		/**
		 * Plugin instance.
		 */
		protected static ?Activate $instance = null;

		/**
		 * Access this plugin’s working instance
		 *
		 * @return Activate
		 */
		public static function getInstance(): ?Activate {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Activate plugin.
		 */
		public function activation() {
			$this->setOption( [
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
			] )->registerOption();
		}
	}
}
