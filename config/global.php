<?php
// Adaptez bien sûr le DSN à votre cas
define('CFG_DB_DSN', 'mysql://root@localhost/db_crud');

define('LIB_DIR',  dirname(__FILE__).'/../lib/');
define('CFG_DIR',  dirname(__FILE__).'/');
define('WEB_DIR',  dirname(__FILE__).'/../web/');
define('HTML_DIR', dirname(__FILE__).'/../html/');

require_once(LIB_DIR.'vendor/doctrine/Doctrine.php');
spl_autoload_register(array('Doctrine_Core', 'autoload'));
?>
