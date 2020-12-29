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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
define( 'FS_METHOD', 'direct' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ':cc[a9UsdpR%Y 8W!59zSzcH@gU>~#:)c@&(a;[EZ.mG8GKN+hG#p1Wd3_p1QOQg' );
define( 'SECURE_AUTH_KEY',  'sh|O`8)AF%z**4tG01AlbO<0O{nrr6SC&_6dnS[37g#M[i:7oSK^7/0<+mg6bao]' );
define( 'LOGGED_IN_KEY',    'hu/,EU+Kl5NlYk0)=9:h`kf.S6fkO4mLDCC:TIz-@3m$$=dqj?p_,k%c.*eL!) T' );
define( 'NONCE_KEY',        'a[Y~D]#]_}=WM-[s^x`I;w/w49AJoCJ6Xecc1`M`Mm=a(kNs#~.W#{2B=x(0&p;4' );
define( 'AUTH_SALT',        'bM`8@W+2Ay$F=o:{_H*FZXKVvqfFVapeEVBH&a(,_eAsdyY+= nV/TQel_~534S{' );
define( 'SECURE_AUTH_SALT', 'NdZP(]vyCI}b`B1167/bDoa$k~?~@JnBW/8:{;,[K;vw16Y7v&Kn5JDXrY-XC]H@' );
define( 'LOGGED_IN_SALT',   'N<<D]%b0?{_TTc)]M>Fwe!-rSae%3K][p~h9T`2EBfHG/_mYNs(,L+OG2DQV[@a0' );
define( 'NONCE_SALT',       '3#<TAie;L>;FI(M*k}X]{LUVQual6N3QL:HrY(=^^6DQYl$Xq{oG{8X_u{Y@(iG7' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
