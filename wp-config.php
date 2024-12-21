<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'letsplaynearby' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'Au].c8/G0p>R[P]6z!AEA^~,A<RCp7VW7.vl}L:yT7x~mMt:`6<Zfiom N1wP{%:' );
define( 'SECURE_AUTH_KEY',  'ZOAKw*Wti+,pU <N$Hl4IBuYAEFx*c%1Zm=;Ai(Enf*$BuDnPKaB9YqdECY1$2 E' );
define( 'LOGGED_IN_KEY',    '[Trp]ZghS}:@z<G-R]IG-2(7jH=&dESC` CCQ1WBJYN<Ji?f>aDO&F~t?rMv453r' );
define( 'NONCE_KEY',        'sef`fYl]Wu48i;+JwP:-5S_|F2#s|;~>Z=[;811EqI_0!nHn<7PdCaPbQwD|{@@i' );
define( 'AUTH_SALT',        '3Lf-eVJeW>W,sz1I@^DU3:e?u$kI3dG(>$%%,9akS%)O,/N_(UqNi.g3)jQcz}M,' );
define( 'SECURE_AUTH_SALT', 'r?hWcq=:HJZDl~(Ax2/=<c=F13ygU3P#Rd-y-t:fPXbCV&6W+X/h$mu>9MJL]LoZ' );
define( 'LOGGED_IN_SALT',   '|.0UzaVg[z _f+gtPRz,{]/l#Jya6^DZ@}wZJuyyw6wf,.dRs=>(A5)no45|MCHK' );
define( 'NONCE_SALT',       'yl$4B;m8.a(,7JvB4*TCR-9~)2=+16!OYa ](R+:M 4E?=4}w;wi3-.+NRx(OY$[' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
