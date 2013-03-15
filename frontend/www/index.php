<?php
/**
 * index.php
 *
 * @author: artuom proskunin <artuomv.proskunin@gmail.com>
 * Date: 13.03.13
 * Time: 15:43
 */

chdir(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');

require_once('common' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Yii' . DIRECTORY_SEPARATOR . 'yii.php');
$config = require('frontend' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php');

$app = Yii::createWebApplication($config);

/**
 * Тут можно зарегистрировать дополнительный Autoloader
 * Например при использовании ZF library
 *
 * Yii::import('common.extensions.EZendAutoloader', true);
 * EZendAutoloader::$prefixes = array('Zend');
 * EZendAutoloader::$basePath = Yii::getPathOfAlias('common.lib') . DIRECTORY_SEPARATOR;
 *
 * Yii::registerAutoloader(array("EZendAutoloader", "loadClass"), true);
 */

$app->run();
