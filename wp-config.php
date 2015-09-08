<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sborka');

/** MySQL database username */
define('DB_USER', 'sborka');

/** MySQL database password */
define('DB_PASSWORD', 'H3s2V4w8');

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
define('AUTH_KEY',         '>d4`6>t|7<YbF4~N-|]3O#[_,ylKJZ1*UxN|kD:@Tmu?|||BS^Ub8hSbc7!tnis]');
define('SECURE_AUTH_KEY',  'Q/Dpi}{H~V8=S3ZRZ*;Q%0JH}z|aB|?ird,oJ}%<+!j/=DB)ljl1YXZuW^h ,W1b');
define('LOGGED_IN_KEY',    '}TiJ%a)6r6{A6HD!T0,n8 zRs}jz%+-w3L{1cTOn[-Y$8b[z$|*|ZP`,17AMu<Xq');
define('NONCE_KEY',        'd|Zbxt@82(?~<&fiSN|uAuE0Q2(o:^l5V,&QPVq4>MU 1Pb^TJ|)/t{B v>&q&y`');
define('AUTH_SALT',        'gcffj=ou<K-qPr`7Rk:.nSeWI(}Apiw;e$;nG/eVm   j/J]ff/JE@+_B^0X2KE}');
define('SECURE_AUTH_SALT', 'h$0_0ZLC:T-12I;~{WHS(b^yd`&,4j8(lLuTQLVEtSMXQ{ON8wS ~O]jBq[z.O2-');
define('LOGGED_IN_SALT',   'IZ]:?4dBl; ,xIRbOuh|-&2@|Z*g5$-1^mZwzB5ws(=#nb:2:z[5cES{gN!;Qs*-');
define('NONCE_SALT',       '%M;;I<L6fQcd*&!>Bf!5u&dE |4||6k-6P#yev ++,n#0Rg,&Q_0&~J5jv|1c+`X');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
