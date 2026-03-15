<?php
if (!function_exists('getenv_docker')) {
	function getenv_docker($env, $default) {
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		}
		else if (($val = getenv($env)) !== false) {
			return $val;
		}
		else {
			return $default;
		}
	}
}

define( 'DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'wordpress') );
define( 'DB_USER', getenv_docker('WORDPRESS_DB_USER', 'example username') );
define( 'DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'example password') );

define( 'DB_HOST', getenv_docker('WORDPRESS_DB_HOST', 'mysql') );
define( 'DB_CHARSET', getenv_docker('WORDPRESS_DB_CHARSET', 'utf8') );
define( 'DB_COLLATE', getenv_docker('WORDPRESS_DB_COLLATE', '') );

define( 'AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY','') );
define( 'SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY','') );
define( 'LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY','') );
define( 'NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY','') );
define( 'AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT','') );
define( 'SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT','') );
define( 'LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT','') );
define( 'NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT','') );

$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');

define( 'WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', '') );

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
	$_SERVER['HTTPS'] = 'on';
}

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
	eval($configExtra);
}

define('PHP_UPLOAD_MAX_FILESIZE', getenv_docker('PHP_UPLOAD_MAX_FILESIZE','256M'));
define('PHP_POST_MAX_SIZE', getenv_docker('PHP_POST_MAX_SIZE','256M'));
define('PHP_MEMORY_LIMIT', getenv_docker('PHP_MEMORY_LIMIT','512M'));
define('PHP_MAX_EXECUTION_TIME', getenv_docker('PHP_MAX_EXECUTION_TIME','300'));
define('PHP_MAX_INPUT_TIME', getenv_docker('PHP_MAX_INPUT_TIME','300'));

// ** Redis Object Cache **
define( 'WP_REDIS_HOST', getenv_docker('WP_REDIS_HOST','') );
define( 'WP_REDIS_PORT', getenv_docker('WP_REDIS_PORT',6379) );
define( 'WP_REDIS_DATABASE', getenv_docker('WP_REDIS_DATABASE',0) );
define( 'WP_REDIS_MAXTTL', getenv_docker('WP_REDIS_MAXTTL',86400) );
define( 'WP_REDIS_PASSWORD', getenv_docker('WP_REDIS_PASSWORD','') );

define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') { $_SERVER['HTTPS']='on'; }

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
        define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

