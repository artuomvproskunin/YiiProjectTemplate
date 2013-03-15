<?php
/* setup default time zone */
date_default_timezone_set('UTC');

/* change dir to root */
chdir(dirname(__FILE__) . '/..');

/* change to set debug mode */
// defined('YII_DEBUG') or define('YII_DEBUG',true);
require_once('common/lib/Yii/yii.php');

$config =  'console/config/default.php';

require_once('common/lib/Yii/yiic.php');
