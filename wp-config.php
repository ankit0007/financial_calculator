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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'loanplguin' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



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
define( 'AUTH_KEY',         'crLAHVlZwXfiqawlqYLYggFSmlXR5wdavl1RFRpGLYRKjTKd3jtvGOxMpwb3n0vB' );
define( 'SECURE_AUTH_KEY',  'lq6juVFXMX8JeRYTYltpAvNmfs7Sv1NoT0OyngLGyo7gUVLVTFWXbVXeFbhg7Ekx' );
define( 'LOGGED_IN_KEY',    'vGOQURQpoBOG0Ma7y82nmEGjYj4XTcG9uUifQy8WgIc6AgBVFHjFpO2Gkrb1xL01' );
define( 'NONCE_KEY',        'jgRmcYMOH3C3WhktLpMrQegrwjq9LGRHjM2Kisb1SGTkmHML9cNXr7uUr7rLsMmr' );
define( 'AUTH_SALT',        'fbg06F64d6ZLPEqlLjLZUjc1KQVDtYIaNByjl72zu6FQMcr5m7S08QHywvbG9G9o' );
define( 'SECURE_AUTH_SALT', 'pT4rKTiL7J8F7y0AV5B8Zvfz9lTalGfH0Pwu0kcX9Z7n94fe9WuFb8JGkVg9BEAK' );
define( 'LOGGED_IN_SALT',   'e22dNIcU8au6y4MVyn52a3E72IfSJFNscfLvfirTOosUeYsUBCI0n1eeiqmbuOai' );
define( 'NONCE_SALT',       'C70f2biP7pVdSvCuiZuAXjF3VwE1hhmhFoFOt001yecIPFrJXADc1q8bFHAsJYI0' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
