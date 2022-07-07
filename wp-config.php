<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'Attractionesadmin' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'AttractionesAdmin' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '112263Attractio' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'F.&1n9ndK^seP|LRTlG%/9D>  }XSLp;2!1HUCYVLk}gduU</%nL%UE$Qd)R_@wq' );
define( 'SECURE_AUTH_KEY',  '_uPd4Rw_6nu]ij5F|G]m)Z$~zV{Y6%]JZ3Z, 6SL?%#b=2)3%w$&Z</$x^0qwiD>' );
define( 'LOGGED_IN_KEY',    '=Dgq$+W9K]C,@+{r0=]xuE>,Z3Lp{-ovU#Dqxchwz,s^5@lg<#2:t8D,meL[xc+>' );
define( 'NONCE_KEY',        ' ?4e;>o$$TCn1o(#DR=ZsSZ~c1C0EIh]hezSsGH}_58h=.hV%uZ7krMN+5;;Q-DN' );
define( 'AUTH_SALT',        'SWzd#IM!23koL(.w=J<NW~{|2aQ$N< =kn;z6Ezkxs0C]x.~z>p_8D~MO<<71>S$' );
define( 'SECURE_AUTH_SALT', '|34Ii-)#dB.{l}jmqAUy_nX]|$w?G3IB$iWVyb9:2LigoE]1ttrVv$O3Y9B%*QE:' );
define( 'LOGGED_IN_SALT',   'z3rq_F;yNaPUoMGp)bp9d;Hv)whZ^)^MF=$Kr0}<ke_c6gsA+++d|i|_QJ$/qsy-' );
define( 'NONCE_SALT',       '6{(*[mT<M]E$GgX/5`gUbl8~z5D<D?4Po+kBQJ|;xD7(skUL1L6|R[@o-dV[[#(P' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
