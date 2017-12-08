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
define('DB_NAME', 'wordpress4');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'J x;ce,b^:`Pw%?8).e%o]gt-k}>PmEe_:(mha3HR%XT!D<_p97@%Y]P}7 l7k1R');
define('SECURE_AUTH_KEY',  '[7rZt1}@1Xf5q4>0;wXwKL a+_IGEBF-ff+WA>Sp?]4jl(NO*HWnmEBXF&TM9/IO');
define('LOGGED_IN_KEY',    '-bh;`9*4|Ous!WAN1Spf6{r/@*0}Fmxq$Hxkdt)^PJ)dDBxNoG#+gy%[FeihD#|I');
define('NONCE_KEY',        ']jdzVAvq?`-wc.QdT<ZN-%0Y)|4W~|m5=e<<+G*Us9[mrwyCr,7SXXc?O=/3*)^G');
define('AUTH_SALT',        'xU6mp1=s=Rb}:HPBwQI**#q`8E!-rvnSMcZekpGvOpE%NT BotE/KQ@vCEj2hwV,');
define('SECURE_AUTH_SALT', 'E2>]0J*[_m {_@?0:|B-FP)/BL7PXgm[YH^C Sxrsom5?l5&pV{P|xrRhL J{/a|');
define('LOGGED_IN_SALT',   'fgg)t~W}0 P)s^;g/zd&%MgfbKOpcU&>l;wdd oEJjac&c])O#XSXz>NF Ye<K-e');
define('NONCE_SALT',       'p^>07j43iT#%`B#8gF=sNqQ}}XUb5cs0(n*S!V(V}6WEHm~(ia(Y,oRwPsvK3[p&');

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
