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
define('DB_NAME', 'fitnessp_c4thpower');

/** MySQL database username */
define('DB_USER', 'fitnessp_usr');

/** MySQL database password */
define('DB_PASSWORD', 'b.+FCD=@j8X*');

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
define('AUTH_KEY',         'H)<u(Zxivw)oaDrH:=.d1jq*4j0oW<5~iBQCE>.kGHk;N?m^z5q:]lm{15&gqc4#');
define('SECURE_AUTH_KEY',  '3v:McM1[GO:,$j>BC u*x=Be}iS*]4}6ZXt4+FHB2P1 3ZF}b8P5u*5/cQ50F.6K');
define('LOGGED_IN_KEY',    '(gyBk@GK,Yq~0}7?SU]!WLQboZ>4bu(i{v=0bd2`t8X#qmmr&A^ x,OAyv#/i2u@');
define('NONCE_KEY',        '*i/2Ujg8 ,>VZ^.Tw=@6OR9OJrZua2;P&7yoyB91A7R3-=@Q3Hi#mVi2,_clP+n@');
define('AUTH_SALT',        '+Q{ZVj5rB$u3(vo+=dtw<|]!,FAQR8Pg<H$/944}2+KI$Yy1|smB=s#!/yRwMi<l');
define('SECURE_AUTH_SALT', '>QR$Ej JG?Ht7SUE`WtsN2rShs;hkJG${I`*Q~*W,6uEeE4kWj9qG!hP=^GOIoh-');
define('LOGGED_IN_SALT',   'K+_DLhBk8El_nqq*BM;,%7jROXkcPR,!%`:Mq%}`xpF~2!o:]Sm!58B(q>R+j^U`');
define('NONCE_SALT',       '<_lECvuSaHRF(M7*zmQ.HbL@hY4~7P.SX2+LU]Od>II 9$8Hv3Q-*] %VMw2Q6#o');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'cp_';

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
