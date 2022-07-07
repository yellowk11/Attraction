<?php
/**
 * Admin class.
 *
 * @package Bvi
 * @since   1.0.0
 */

namespace Bvi\Core;

if ( ! class_exists( 'Bvi' ) ) {

	/**
	 * Class Bvi
	 * @package Bvi\Core
	 */
	class Bvi extends Core {

		/**
		 * Bvi constructor.
		 */
		public function __construct() {
			$option = $this->getOption();

			add_action( 'plugins_loaded', function () {
				load_plugin_textdomain( 'bvi', false, BVI_LANG_PATH );
			}, 10, 0 );

			if ( ! empty( $option['bviActive'] ) && filter_var( $option['bviActive'], FILTER_VALIDATE_BOOLEAN ) ) {
				add_action( 'wp_enqueue_scripts', [ $this, 'frontendAssets' ], 999, 0 );
				add_shortcode( 'bvi', [ $this, 'shortcode' ] );
			}
		}

		/**
		 * Add bvi shortcode.
		 *
		 * @param array $attributes
		 *
		 * @return string
		 */
		public function shortcode( $attributes ): string {
			$svgEye = '<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="bvi-svg-eye"><path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z" class="bvi-svg-eye"></path></svg>';

			if ( is_array( $attributes ) ) {
				$shortcode_atts = shortcode_atts(
					[
						'text' => __( 'Версия сайта для слабовидящих', 'bvi' ),
					],
					$attributes
				);


				$return = '<div class="bvi-shortcode"><a href="#" class="bvi-open">' . $svgEye . '&ensp;' . esc_html( $shortcode_atts['text'] ) . '</a></div>';
			} else {
				$return = '<div class="bvi-shortcode"><a href="#" class="bvi-open">' . $svgEye . '</a></div>';
			}


			return $return;
		}

		/**
		 * Frontend assets.
		 */
		public function frontendAssets() {
			$option = $this->getOption();

			wp_register_style( 'bvi-styles', BVI_URL_CSS . 'bvi.min.css', true, BVI_VERSION );
			$custom_css = "
			.bvi-widget,
			.bvi-shortcode a,
			.bvi-widget a, 
			.bvi-shortcode {
				color: {$option['bviLinkColor']};
				background-color: {$option['bviLinkBg']};
			}
			.bvi-widget .bvi-svg-eye,
			.bvi-shortcode .bvi-svg-eye {
			    display: inline-block;
                overflow: visible;
                width: 1.125em;
                height: 1em;
                font-size: 2em;
                vertical-align: middle;
			}
			.bvi-widget,
			.bvi-shortcode {
			    -webkit-transition: background-color .2s ease-out;
			    transition: background-color .2s ease-out;
			    cursor: pointer;
			    border-radius: 2px;
			    display: inline-block;
			    padding: 5px 10px;
			    vertical-align: middle;
			    text-decoration: none;
			}";
			wp_add_inline_style( 'bvi-styles', $custom_css );
			wp_enqueue_style( 'bvi-styles' );

			wp_register_script( 'bvi-script', BVI_URL_JS . 'bvi.min.js', false, BVI_VERSION, true );
			wp_localize_script( 'bvi-script', 'wp_bvi', [
				'option' => [
					'theme'         => (string) $option['bviTheme'],
					'font'          => (string) $option['bviFont'],
					'fontSize'      => (int) $option['bviFontSize'],
					'letterSpacing' => (string) $option['bviLetterSpacing'],
					'lineHeight'    => (string) $option['bviLineHeight'],
					'images'        => ( $option['bviImages'] === 'grayscale' ) ? $option['bviImages'] : filter_var( $option['bviImages'], FILTER_VALIDATE_BOOLEAN ),
					'reload'        => filter_var( $option['bviReload'], FILTER_VALIDATE_BOOLEAN ),
					'speech'        => filter_var( $option['bviSpeech'], FILTER_VALIDATE_BOOLEAN ),
					'builtElements' => filter_var( $option['bviBuiltElements'], FILTER_VALIDATE_BOOLEAN ),
					'panelHide'     => filter_var( $option['bviPanelHide'], FILTER_VALIDATE_BOOLEAN ),
					'panelFixed'    => filter_var( $option['bviPanelFixed'], FILTER_VALIDATE_BOOLEAN ),
					'lang'          => (string) $option['bviLang'],
				],
			] );
			wp_add_inline_script( 'bvi-script', 'var Bvi = new isvek.Bvi(wp_bvi.option);' );
			wp_enqueue_script( 'bvi-script' );
		}
	}
}