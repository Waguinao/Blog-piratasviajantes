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

define('DB_NAME', 'viajantespiratasblog');

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
define('AUTH_KEY',         '0DS+oKB}-47N<+!}y9 (tf<(etXNZ|$}jNpP/2riD8Nlmq)x3)V xC~@.6:PwumK');
define('SECURE_AUTH_KEY',  'IhKyUC( AKG ULsr=(v-$P~7m0>Bmgjqk{CK/=<@(F(_|n3%z_d<sLHY7jmJ2PE+');
define('LOGGED_IN_KEY',    '5`=8aiU2y--p.PJZ@jGi4t_h_(<vAEJq_JZPg2zVnBUFZH7S`@3^_avpU5u]8Zo@');
define('NONCE_KEY',        '>OYgcKm#O;LQO^|YfwxE4WF]%@.YlW8Oo_QyQ5P=%QW|gwyE!qyjczy./=U4El8;');
define('AUTH_SALT',        '6u&yUwp&]* 0Ys]LkA&Hw{.mJbIK~]B}+rB(MLVw~{hoQ$RLJRjGuM<E..OpDpn2');
define('SECURE_AUTH_SALT', 'NFv>,5Wk= k[:ELOSzfRl#Rve#SQ(dQzouYB?:;#{;)mYFxcL5&Q+7{rsT}A900:');
define('LOGGED_IN_SALT',   'qn$.Ma_g#[TATj*[DLuB)Jt:F>Du-*9($!jRYE9nNXA/IoPzmmmp,7sKp,#$[y!&');
define('NONCE_SALT',       'cOc/wx=}GWxiYj87lO5?F^;}hC*b)5<W&{H?edbP}m?MKF2S^==6}Oz+p4DFBtxd');

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
