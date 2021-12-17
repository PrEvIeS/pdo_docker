<?
define("DBPersistent", false);
$DBType = "mysql";
$DBDebug = false;
$DBDebugToFile = false;

$DBHost = getenv('MYSQL_HOST') ?: 'localhost';
$DBName = getenv('MYSQL_DATABASE') ?: 'gold';
$DBLogin = getenv('MYSQL_USER') ?: 'gold';
$DBPassword = getenv('MYSQL_PASSWORD') ?: 'gold';
define("BX_USE_MYSQLI", true);

define("DELAY_DB_CONNECT", true);
define("CACHED_b_file", 3600);
define("CACHED_b_file_bucket_size", 10);
define("CACHED_b_lang", 3600);
define("CACHED_b_option", 3600);
define("CACHED_b_lang_domain", 3600);
define("CACHED_b_site_template", 3600);
define("CACHED_b_event", 3600);
define("CACHED_b_agent", 3660);
define("CACHED_menu", 3600);

define("BX_UTF", true);
define("BX_FILE_PERMISSIONS", 0664);
define("BX_DIR_PERMISSIONS", 0775);
@umask(~BX_DIR_PERMISSIONS);
define("BX_DISABLE_INDEX_PAGE", true);
//---------------------------
