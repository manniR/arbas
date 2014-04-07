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
define('DB_NAME', 'dev.arbas.at');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'pa<NDe~;{ciK~4mgy7dno|m<yB1A+){4pn)yN9|#4z5uHJ*H(#@B)KP0@HK[9Bt2');
define('SECURE_AUTH_KEY',  '+zJE q,dF<<B[I7I~h7nvVPK;G8A2# jryuSsj(>m dlu&W*_n|p!lhQ(H-Hn&d6');
define('LOGGED_IN_KEY',    ' {pB_K^8i!pn+yE79Fr-/v[mV[M}vP;$i6#r!:BVj~GAO.d9;Kj0%6rFKcp#tq4X');
define('NONCE_KEY',        'aD2bHw(0@Vi@i^fZ8T{8Z-r(*P}{evS)|GL%V+IY|gV!-Vx3HZ~PrNd?8TVlG%|0');
define('AUTH_SALT',        '+2}y2FGN3b+c]aONts+|PL~Wy(T[.nQ6t|SxyG+`pT9-~yt nJ[` ,&9zYXK-+Yt');
define('SECURE_AUTH_SALT', ')i~DI(}H]L^JHT}5_D+HmXBOA6D+k`F5I-N^1G&_|ZV-l YO>gv>LZP{!jP&cH>z');
define('LOGGED_IN_SALT',   'U{jis lmlaep<7rvzoTW%$9[U&pYVOP>0R6+-l5-M}<7{.t[e8Ldu_<p58@-N/^7');
define('NONCE_SALT',       '=|pT?mF/-)8OO<NQbCgbg+wB-{k+RlF|j5GZF`MS/T273QI]04xZn%i|->VQB&L(');

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
