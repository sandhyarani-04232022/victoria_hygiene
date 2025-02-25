<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'smO4{&p?9:?1/n?x2LCa}YluTvOI.g1=YA;)cju.H9yAQ4xILQCe;i?<1ul(J1jg' );
define( 'SECURE_AUTH_KEY',   '](8s);KhcHuxJfdR?o!e+:Dv)8L`}CP13i@i5B7A6(l%fKS5%FZ}|fGwfAiB19CH' );
define( 'LOGGED_IN_KEY',     ']m4?%6]1dJp_!A_OdSsN9UqI8Z6NiuRAM<]M`hk?Id]bqz#CioUsI*GRh!6 16b|' );
define( 'NONCE_KEY',         'ip~9SAt#{=<B#Y#^}*Ybop=x;k,#MFJ Nv`b<$:q}n7~U!l7)UmQ^3SLP!G;5%MG' );
define( 'AUTH_SALT',         '=Diy@C& t5*3h=mW:#kAua:i[oLD3LNQbZp7XnZM45tgtFKV0p#?;kTmUEuZ#S+j' );
define( 'SECURE_AUTH_SALT',  'pd@Z?TzZ_^gHn5?1mG8}&@|zIM&A4<{c!@_MUlfDKt;q[sI$F%4b/-$@4vrz$.4(' );
define( 'LOGGED_IN_SALT',    '8@r@GHXGn/V>DPl<<[LZwEel+(V00wZ@d77l:7[F=tb+!%fdlp3/O>/E{ }`qsAy' );
define( 'NONCE_SALT',        'sWM.sY=aBT=PWZnF+=%0$V1YL?aYdej!I,#@G]n>vT*JFGbE1y!RX&A7V_l]Oe`c' );
define( 'WP_CACHE_KEY_SALT', '3u!]M?H}pTaegn,6w>gB1W(*=<;Zn((_i<VM!mcRg3GB5x.F.=}(Ddkli5p7]N@O' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
