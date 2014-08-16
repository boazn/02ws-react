<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wrd1');

/** MySQL database username */
define('DB_USER', 'boazn');

/** MySQL database password */
define('DB_PASSWORD', '854456');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '0F9DmOFNjv6jxQDVPyD2SACht8vExviVv1T5BiMtHvy2IrgmsQP30nPFWywWKY3J');
define('SECURE_AUTH_KEY',  'HMBfgC2OfrQ1qNIFuQKKcyVM3hi49xD6ZPbuAfKxnBeWUWKbsKthz2FCLpiFKGJK');
define('LOGGED_IN_KEY',    'FKtqXLdR1SAkzEsYW4XKacotSfK6VeG9gRpWvzW2xYi4exRNoc0Bk9ekYwBS2SSj');
define('NONCE_KEY',        'fKO5OOZqyMcz8sNEjSepEISp6IMtVSScGVzYVlLbYP7YrKd40PVRGnJO6Hvr0x8I');
define('AUTH_SALT',        'gN6bJ5F7xHVkXZMJbupxTRxgf9wiXOcDayokIAYAXSTkd1BIdomd1fSz4GUqnZPN');
define('SECURE_AUTH_SALT', 'IKq8NtLXZVG3BCS7o8DHnOTJcS0iv9EAliDWy2mHRFiSqeT6akAdWek8F6l16YFB');
define('LOGGED_IN_SALT',   'ytm5tQFKWS1NKtqNDptVJJgYn7bRvYMoZCJ0kWrIzCYmSCFqA52zsy8mBeJFPXaB');
define('NONCE_SALT',       'K7tcSMPwbyJZLiShvcEqalIKBECJPiKg24FmZI3CjrIR7DLrdOXUzhcq03PBu1OV');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
