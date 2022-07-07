<?php
/**
 * Upgrade class.
 *
 * @package Bvi
 * @since   1.0.0
 */

namespace Bvi\Core;

if ( ! class_exists( 'Upgrade' ) ) {

	/**
	 * Class Upgrade
	 * @package Bvi\Core
	 */
	class Upgrade extends Core {

		/**
		 * Plugin instance.
		 */
		protected static ?Upgrade $instance = null;

		/**
		 * Access this plugin’s working instance
		 *
		 * @return Upgrade
		 */
		public static function getInstance(): ?Upgrade {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Update process complete.
		 *
		 * @param \WP_Upgrader $upgrader
		 * @param array $hook_extra
		 */
		public function updateProcessComplete( \WP_Upgrader $upgrader, array $hook_extra ) {
			$updated = false;
			if ( is_array( $hook_extra ) && array_key_exists( 'action', $hook_extra ) && array_key_exists( 'type', $hook_extra ) && array_key_exists( 'plugins', $hook_extra ) ) {
				if ( $hook_extra['action'] == 'update' && $hook_extra['type'] == 'plugin' && is_array( $hook_extra['plugins'] ) && ! empty( $hook_extra['plugins'] ) ) {
					$this_plugin = plugin_basename( BVI_FILE );
					foreach ( $hook_extra['plugins'] as $key => $plugin ) {
						if ( $this_plugin == $plugin ) {
							$updated = true;
							set_transient( 'bvi_updated', 1 );
							break;
						}
					}
					unset( $key, $plugin, $this_plugin );
				}
			}

			if ( ! $updated ) {
				return;
			}

			Activate::getInstance()->activation();
		}

		/**
		 * Update plugin.
		 */
		public function updatePlugin() {
			if ( get_transient( 'bvi_updated' ) && current_user_can( 'administrator' ) ) {
				Activate::getInstance()->activation();
			}
		}

		/**
		 * Register hook.
		 */
		public function registerUpgrade() {
			add_action( 'upgrader_process_complete', [ $this, 'updateProcessComplete' ], 10, 2 );
			add_action( 'plugins_loaded', [ $this, 'updatePlugin' ] );
		}
	}
}
