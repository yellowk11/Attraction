<?php
/**
 * Admin class.
 *
 * @package Bvi\Core
 * @since   1.0.0
 */

namespace Bvi\Core;

use Bvi\Core\FieldsAdmin\Color;
use Bvi\Core\FieldsAdmin\Radio;
use Bvi\Core\FieldsAdmin\Select;
use Bvi\Core\FieldsAdmin\Text;

if ( ! class_exists( 'Admin' ) ) {

	/**
	 * Class Admin
	 * @package Bvi\Core
	 */
	class Admin extends Core {

		/**
		 * @var Text
		 */
		protected Text $fieldText;

		/**
		 * @var Select
		 */
		protected Select $fieldSelect;

		/**
		 * @var Radio
		 */
		protected Radio $fieldRadio;

		/**
		 * @var Color
		 */
		protected Color $fieldColor;

		/**
		 * Admin constructor.
		 */
		public function __construct() {
			$this->fieldText   = new Text();
			$this->fieldSelect = new Select();
			$this->fieldRadio  = new Radio();
			$this->fieldColor  = new Color();

			add_action( 'admin_menu', [ $this, 'adminMenu' ] );
			add_action( 'admin_init', [ $this, 'registerSetting' ] );
		}

		/**
		 * Get font size array.
		 *
		 * @param int $size
		 *
		 * @return array
		 */
		protected function getFontSize( int $size = 0 ): array {
			$array = [];

			if ( $size !== 0 ) {
				for ( $i = 1; $i <= $size; $i ++ ) {
					$array[ $i ] = $i;
				}
			}

			return $array;
		}

		/**
		 * Default options value.
		 *
		 * @return string[]
		 */
		public function defaultOptionsValue(): array {
			return [
				'bviActive'        => '/^(true|false|1|0)$/',
				'bviTheme'         => '/^(white|black|blue|brown|green)$/',
				'bviFont'          => '/^(arial|times)$/',
				'bviFontSize'      => '/^([1-9]|[1-3][0-9])$/',
				'bviLetterSpacing' => '(normal|average|big)',
				'bviLineHeight'    => '(normal|average|big)',
				'bviImages'        => '(true|false|1|0|grayscale)',
				'bviReload'        => '/^(true|false|1|0)$/',
				'bviSpeech'        => '/^(true|false|1|0)$/',
				'bviBuiltElements' => '/^(true|false|1|0)$/',
				'bviPanelHide'     => '/^(true|false|1|0)$/',
				'bviPanelFixed'    => '/^(true|false|1|0)$/',
				'bviLang'          => '(ru-RU|en-US)',
				'bviLinkColor'     => '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/',
				'bviLinkBg'        => '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/',
			];
		}

		/**
		 * Add admin menu page.
		 */
		public function adminMenu() {
			$menu = add_menu_page(
				$this->pluginName,
				$this->pluginNameShort,
				'administrator',
				$this->pluginMenuSlug,
				[ $this, 'displayOptionSettings' ],
				'dashicons-universal-access-alt',
				80
			);

			add_action( "admin_print_scripts-" . $menu, [ $this, 'addScriptsSettingsPage' ], 99 );
			add_action( "admin_print_styles-" . $menu, [ $this, 'addStylesSettingsPage' ], 99 );
		}

		/**
		 * Add scripts js.
		 */
		public function addScriptsSettingsPage() {
			//
		}

		/**
		 * Add styles css.
		 */
		public function addStylesSettingsPage() {
			wp_register_style( 'bvi-styles', false );
			$custom_css = "
			#poststuff .inside h2 {
			    font-size: 18px;
			    padding: 8px 0;
			    border-bottom: 1px solid #E6E6E6;
			    font-weight: 500;
			}";
			wp_add_inline_style( 'bvi-styles', $custom_css );
			wp_enqueue_style( 'bvi-styles' );
		}

		/**
		 * Register options.
		 */
		public function registerSetting() {
			register_setting(
				$this->pluginOptionGroup,
				$this->pluginOptionName,
				[
					'sanitize_callback' => [ $this, 'sanitizeCallback' ],
					'default'           => ''
				]
			);

			add_settings_section(
				$this->pluginSettingsSection,
				__( 'Внешний вид версии сайта для слабовидящих', 'bvi' ),
				null,
				$this->pluginMenuSlug
			);

			add_settings_section(
				$this->pluginSettingsSection . '-widget',
				__( 'Настройки виджета и шорткода', 'bvi' ),
				null,
				$this->pluginMenuSlug
			);

			add_settings_field(
				'bviActive',
				__( 'Плагин активен', 'bvi' ),
				[ $this->fieldRadio, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'      => 'bviActive',
					'label_for' => 'bviActive',
					'value'     => [
						'false' => __( 'Нет', 'bvi' ),
						'true'  => __( 'Да', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviTheme',
				__( 'Цветовая гамма', 'bvi' ),
				[ $this->fieldSelect, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'      => 'bviTheme',
					'label_for' => 'bviTheme',
					'value'     => [
						'white' => __( 'Белым по черному', 'bvi' ),
						'black' => __( 'Черным по белому', 'bvi' ),
						'blue'  => __( 'Темно-синим по голубому', 'bvi' ),
						'brown' => __( 'Коричневым по бежевому', 'bvi' ),
						'green' => __( 'Зеленым по темно-коричневому', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviTheme',
				__( 'Цветовая гамма', 'bvi' ),
				[ $this->fieldSelect, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'      => 'bviTheme',
					'label_for' => 'bviTheme',
					'value'     => [
						'white' => __( 'Белым по черному', 'bvi' ),
						'black' => __( 'Черным по белому', 'bvi' ),
						'blue'  => __( 'Темно-синим по голубому', 'bvi' ),
						'brown' => __( 'Коричневым по бежевому', 'bvi' ),
						'green' => __( 'Зеленым по темно-коричневому', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviFontSize',
				__( 'Размер шрифта', 'bvi' ),
				[ $this->fieldSelect, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'        => 'bviFontSize',
					'label_for'   => 'bviFontSize',
					'description' => __( 'Значение в пикселях.', 'bvi' ),
					'value'       => $this->getFontSize( 39 ),
				],
			);

			add_settings_field(
				'bviFont',
				__( 'Шрифт', 'bvi' ),
				[ $this->fieldSelect, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'      => 'bviFont',
					'label_for' => 'bviFont',
					'value'     => [
						'arial' => __( 'Без засечек - Arial', 'bvi' ),
						'times' => __( 'С засечками - Times New Roman', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviLetterSpacing',
				__( 'Межбуквенный интервал', 'bvi' ),
				[ $this->fieldSelect, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'        => 'bviLetterSpacing',
					'label_for'   => 'bviLetterSpacing',
					'description' => 'Задайте расстояние между буквами, так называемую "разрядку".',
					'value'       => [
						'normal'  => __( 'Одинарный', 'bvi' ),
						'average' => __( 'Полуторный', 'bvi' ),
						'big'     => __( 'Двойной', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviLineHeight',
				__( 'Междустрочный интервал', 'bvi' ),
				[ $this->fieldSelect, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'        => 'bviLineHeight',
					'label_for'   => 'bviLineHeight',
					'description' => 'Задайте вертикальное расстояние между строками.',
					'value'       => [
						'normal'  => __( 'Одинарный', 'bvi' ),
						'average' => __( 'Полуторный', 'bvi' ),
						'big'     => __( 'Двойной', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviImages',
				__( 'Адаптация изображений', 'bvi' ),
				[ $this->fieldSelect, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'      => 'bviImages',
					'label_for' => 'bviImages',
					'value'     => [
						'true'      => __( 'Изображения включены', 'bvi' ),
						'false'     => __( 'Изображения отключены', 'bvi' ),
						'grayscale' => __( 'Серая гамма', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviReload',
				__( 'Включить перезагрузку страницы', 'bvi' ),
				[ $this->fieldRadio, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'        => 'bviReload',
					'label_for'   => 'bviReload',
					'description' => __( 'При переходе на обычную версию сайта текущая страница будет презагружена.', 'bvi' ),
					'value'       => [
						'false' => __( 'Нет', 'bvi' ),
						'true'  => __( 'Да', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviSpeech',
				__( 'Включить синтез речи', 'bvi' ),
				[ $this->fieldRadio, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'        => 'bviSpeech',
					'label_for'   => 'bviSpeech',
					'description' => __( 'Синтезатор речи озвучит вслух изменения настроек отображения, которые произведёт пользователь.', 'bvi' ),
					'value'       => [
						'false' => __( 'Нет', 'bvi' ),
						'true'  => __( 'Да', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviBuiltElements',
				__( 'Включить встроенные элементы', 'bvi' ),
				[ $this->fieldRadio, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'        => 'bviBuiltElements',
					'label_for'   => 'bviBuiltElements',
					'description' => __( 'Встроенные элементы - это компонент HTML-элемента, который позволяет встраивать документы, видео, карты и интерактивные медиафайлы на страницу.', 'bvi' ),
					'value'       => [
						'false' => __( 'Нет', 'bvi' ),
						'true'  => __( 'Да', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviPanelHide',
				__( 'Скрыть панель настроек плагина', 'bvi' ),
				[ $this->fieldRadio, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'        => 'bviPanelHide',
					'label_for'   => 'bviPanelHide',
					'description' => __( 'Панель настроек плагина для пользователя скроется, когда пользователь включит версию вашего сайта для слабовидящих, в место неё будет выводится иконка плагина.', 'bvi' ),
					'value'       => [
						'false' => __( 'Нет', 'bvi' ),
						'true'  => __( 'Да', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviPanelFixed',
				__( 'Зафиксировать панель настроек плагина в верхней части страницы', 'bvi' ),
				[ $this->fieldRadio, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'        => 'bviPanelFixed',
					'label_for'   => 'bviPanelFixed',
					'description' => __( 'Панель настроек плагина для пользователя будет зафиксирована в верхней части при прокрутке страницы.', 'bvi' ),
					'value'       => [
						'false' => __( 'Нет', 'bvi' ),
						'true'  => __( 'Да', 'bvi' ),
					],
				],
			);

			add_settings_field(
				'bviLang',
				__( 'Язык панели', 'bvi' ),
				[ $this->fieldSelect, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection,
				[
					'name'        => 'bviLang',
					'label_for'   => 'bviLang',
					'description' => '',
					'value'       => [
						'ru-RU' => 'ru-RU',
						'en-US' => 'en-US',
					],
				],
			);

			add_settings_field(
				'bviLinkText',
				'Текст виджета ссылки для переключения версии сайта',
				[ $this->fieldText, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection . '-widget',
				[
					'name'        => 'bviLinkText',
					'label_for'   => 'bviLinkText',
					'description' => __( 'Данный текст не применяется в шорткоде.', 'bvi' ),
				],
			);

			add_settings_field(
				'bviLinkColor',
				'Цвет ссылки для переключения версии сайта',
				[ $this->fieldColor, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection . '-widget',
				[
					'name'        => 'bviLinkColor',
					'label_for'   => 'bviLinkColor',
					'description' => 'Данный цвет применяется в виджете, шорткоде и иконки.',
				],
			);

			add_settings_field(
				'bviLinkBg',
				'Фон ссылки для переключения версии сайта',
				[ $this->fieldColor, 'render' ],
				$this->pluginMenuSlug,
				$this->pluginSettingsSection . '-widget',
				[
					'name'        => 'bviLinkBg',
					'label_for'   => 'bviLinkBg',
					'description' => 'Данный цвет применяется в виджете и шорткоде.',
				],
			);
		}

		/**
		 * Display option settings.
		 */
		public function displayOptionSettings() {
			if ( current_user_can( 'administrator' ) ) : ?>
                <div class="wrap">
                    <h1 class="wp-heading-inline"><?php echo $this->pluginName; ?><sup><small
                                    style="font-size: small">v<?php echo BVI_VERSION; ?></small></sup>
                        - <?php _e( 'Настройки', 'bvi' ); ?></h1>
                    <hr class="wp-header-end">
                    <div id="poststuff">
                        <div id="post-body" class="metabox-holder columns-2">
                            <div id="postbox-container-1" class="postbox-container">
                                <div id="side-sortables" class="meta-box-sortables ui-sortable">
                                    <div class="postbox">
                                        <h2><?php echo $this->pluginName . ' ' . BVI_VERSION; ?>
                                            - <?php _e( 'плагин доступности сайта для слабовидящих', 'bvi' ); ?></h2>
                                        <div class="inside">
                                            <div id="submitpost" class="submitbox">
												<?php _e( 'Мы распространием этот плагин на бесплатной основе, но его написание, поддержка и распространение требует от нас вложения времени, сил и средств. Пожертвования пользователей могут позволить нам развивать и поддерживать плагин бесплатно.<br><br> Если плагин полезен для вас - пожалуйста рассмотрите возможность', 'bvi' ); ?>
                                                <a href="https://bvi.isvek.ru/donate/" rel="noopener noreferrer"
                                                   style="color: red !important;" target="_blank">
													<?php _e( 'сделать пожертвование', 'bvi' ); ?></a>.
                                                <br><br>
												<?php _e( 'Спасибо за использование Button visually impaired', 'bvi' ); ?>
                                                !!!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="postbox">
                                        <h2><?php _e( 'Полезные ссылки', 'bvi' ); ?></h2>
                                        <div class="inside">
                                            <ul>
                                                <li>
                                                    <i aria-hidden="true" class="dashicons dashicons-external"></i>
                                                    <a href="https://bvi.isvek.ru/ustanovka-plagina/wordpress/"
                                                       rel="noopener noreferrer"
                                                       target="_blank"><?php _e( 'Документация', 'bvi' ); ?></a>
                                                </li>
                                                <li>
                                                    <i aria-hidden="true" class="dashicons dashicons-external"></i>
                                                    <a href="https://wordpress.org/support/plugin/button-visually-impaired/"
                                                       rel="noopener noreferrer"
                                                       target="_blank"><?php _e( 'Wordpress Форум', 'bvi' ); ?></a>
                                                </li>
                                                <li>
                                                    <i aria-hidden="true" class="dashicons dashicons-external"></i>
                                                    <a href="https://github.com/veks/button-visually-impaired-javascript/issues"
                                                       rel="noopener noreferrer"
                                                       target="_blank"><?php _e( 'Github Форум', 'bvi' ); ?></a>
                                                </li>
                                                <li>
                                                    <i aria-hidden="true" class="dashicons dashicons-external"></i>
                                                    <a href="https://bvi.isvek.ru/donate/" rel="noopener noreferrer"
                                                       target="_blank"><?php _e( 'Сделать пожертвование', 'bvi' ); ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="postbox">
                                        <h2><?php _e( 'Обратная связь', 'bvi' ); ?></h2>
                                        <div class="inside">
                                            <ul>
                                                <li>
													<?php _e( 'Электронная почта', 'bvi' ); ?>
                                                    : bvi@isvek.ru
                                                    <a href="mailto:bvi@isvek.ru">
														<?php _e( 'Написать письмо', 'bvi' ); ?>
                                                    </a>
                                                </li>
                                                <li>
													<?php _e( 'Форма обратной связи', 'bvi' ); ?> -
                                                    <a href="https://bvi.isvek.ru/feedback/" rel="noopener noreferrer"
                                                       target="_blank">
														<?php _e( 'Перейти', 'bvi' ); ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="postbox-container-2" class="postbox-container">
                                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                                    <div class="postbox">
										<?php settings_errors(); ?>
                                        <div class="inside">
                                            <form action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>"
                                                  method="post">
												<?php settings_fields( $this->pluginOptionGroup ); ?>
												<?php do_settings_sections( $this->pluginMenuSlug ); ?>
												<?php submit_button(); ?>
                                                <br class="clear">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br class="clear">
                    </div>
                </div>
			<?php endif;
		}

		/**
		 * Sanitize callback.
		 *
		 * @param $input
		 *
		 * @return array|bool
		 */
		public function sanitizeCallback( $input ) {
			$option = $this->getOption();
			$type   = 'update';

			if ( $this->getOption() === false ) {
				add_settings_error( $this->pluginOptionName, 'get-option', __( 'Значение указанной настройки (опции) нет.', 'bvi' ), $type = 'error' );
			}

			if ( is_array( $this->defaultOptionsValue() ) ) {
				foreach ( $this->defaultOptionsValue() as $key => $value ) {
					if ( ! empty( $input[ $key ] ) && preg_match( $value, $input[ $key ] ) ) {
						$option[ $key ] = sanitize_text_field( $input[ $key ] );
					} else {
						add_settings_error( $this->pluginOptionName, $key, __( 'Неправильное значение для поля', 'bvi' ) . "<a href='#$key'>{$this->getNameValueOfKeys($key)}</a>.", $type = 'error' );
					}
				}
			}

			if ( $type === 'error' ) {
				return $this->getOption();
			} else {
				return $option;
			}
		}

		/**
		 * Get error name.
		 *
		 * @param $key
		 *
		 * @return string
		 */
		public function getNameValueOfKeys( $key ): string {
			$array = [
				'bviActive'         => __( 'Плагин активен', 'bvi' ),
				'bviScriptLocation' => 'false',
				'bviTheme'          => __( 'Цветовая гамма', 'bvi' ),
				'bviFont'           => __( 'Шрифт', 'bvi' ),
				'bviFontSize'       => __( 'Размер шрифта', 'bvi' ),
				'bviLetterSpacing'  => __( 'Межбуквенный интервал', 'bvi' ),
				'bviLineHeight'     => __( 'Междустрочный интервал', 'bvi' ),
				'bviImages'         => __( 'Адаптация изображений', 'bvi' ),
				'bviReload'         => __( 'Включить перезагрузку страницы', 'bvi' ),
				'bviSpeech'         => __( 'Включить синтез речи', 'bvi' ),
				'bviBuiltElements'  => __( 'Включить встроенные элементы', 'bvi' ),
				'bviPanelHide'      => __( 'Скрыть панель настроек плагина', 'bvi' ),
				'bviPanelFixed'     => __( 'Зафиксировать панель настроек плагина в верхней части страницы', 'bvi' ),
				'bviLang'           => __( 'Язык панели', 'bvi' ),
				'bviLinkColor'      => __( 'Цвет ссылки для переключения версии сайта', 'bvi' ),
				'bviLinkBg'         => __( 'Фон ссылки для переключения версии сайта', 'bvi' ),
				'bviLinkText'       => __( 'Текст виджета ссылки для переключения версии сайта', 'bvi' ),
			];

			return $array[ $key ];
		}
	}
}
