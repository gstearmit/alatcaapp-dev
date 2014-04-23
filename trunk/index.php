<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('SERVER_ENVIRONMENT') ||
define('SERVER_ENVIRONMENT','magazine.publish.localhost:8093');
defined('WEB_PATH') ||
define('WEB_PATH','http://magazine.publish.localhost:8093');

define('CK_BASE_PATH','/alatcamagazin-dev');

defined('ROOT_PATH') || 
define('ROOT_PATH',
        realpath(dirname(__FILE__))); 

defined('APPLICATION_PATH') || 
define('APPLICATION_PATH',
        realpath(dirname(__FILE__).'/application'));


defined('APPLICATION_ENV') || 
define('APPLICATION_ENV',
       (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
        :'developer'));
// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV',
(getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
: 'development'));

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV',
(getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
: 'testing'));

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV',
(getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
: 'production'));

defined('IMAGE_LIB_PATH') ||
define('IMAGE_LIB_PATH','D:/wkhtml/wkhtmltoimage.exe');
defined('PDF_LIB_PATH') ||
define('PDF_LIB_PATH','D:/wkhtml/wkhtmltoipdf.exe');
define('PAGING_SIZE',30);
define('DEBUG', 0);

define('MAX_IMAGE_FILE_SIZE',1024*1024);
define('NEWS_IMAGE_PATH','D:/xampp/htdocs/alatcamagazin-dev/public/uploads/news/');
define('IMAGE_TYPE_ALLOW','gif,jpg,png,bmp');
define('DOC_TYPE_ALLOW','txt,html,htm,pdf,odt,ods,rtf,doc,docx,xls,xlsx,gif,png,jpg,jpeg,bmp,zip,rar,7z');

set_include_path(
        implode(PATH_SEPARATOR, 
                array(dirname(__FILE__).'/library',
                    get_include_path(),)));   

require_once 'Zend/Application.php';


$environment=APPLICATION_ENV;
$options= APPLICATION_PATH.'/configs/application.ini';


$application= new Zend_Application($environment,$options);
$application->bootstrap()->run();

?>
