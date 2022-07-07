<?php
/**
 * Loader class.
 *
 * @package Bvi\Core
 * @since   1.0.0
 */

namespace Bvi\Core;

if ( ! class_exists( 'Loader' ) ) {

	/**
	 * Class Loader
	 * @package Bvi\Core
	 */
	class Loader {

		/**
		 * Plugin instance.
		 */
		protected static ?Loader $instance = null;

		/**
		 * @var array|string[]
		 */
		protected array $classes = [];

		/**
		 * Access this plugin’s working instance
		 *
		 * @return Loader
		 */
		public static function getInstance(): Loader {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Store all the classes inside an array.
		 *
		 * @return array classes.
		 */
		private function getClasses(): array {
			return $this->classes;
		}

		/**
		 * Set classes.
		 *
		 * @param $classes
		 *
		 * @return $this
		 */
		public function setClasses( $classes ): Loader {
			$this->classes = array_merge( $this->classes, $classes );

			return $this;
		}

		/**
		 * Unset classes.
		 *
		 * @param $unsetClasses
		 */
		public function unsetClasses( $unsetClasses ) {
			if ( ! isset( $this->classes ) ) {
				return;
			}

			$classFlip = array_flip( $this->classes );

			if ( is_array( $unsetClasses ) ) {
				foreach ( $unsetClasses as $class ) {
					if ( in_array( $class, $classFlip ) ) {
						unset( $this->classes[ $classFlip[ $class ] ] );
					}
				}
			} else {
				unset( $this->classes[ $classFlip[ $unsetClasses ] ] );
			}
		}

		/**
		 * Register class.
		 *
		 * @return array new classes.
		 */
		public function register(): array {
			$classes = [];

			foreach ( $this->classes as $class ) {
				$classes[] = new $class;
			}

			return $classes;
		}
	}
}
