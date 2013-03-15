<?php
/**
 * main.php
 *
 * @author: artuom proskunin <artuomv.proskunin@gmail.com>
 */

/**
 * Специфичные для данного приложения конфигурационные файлы и настройки
 * Часть содержимого $config
 */

/**
 * Например:
 * Файл additionalSettings содержит часть основного конфига в виде:
 * return array(
 *      ...
 *      'some_param' => 'some_value'
 *      ...
 * );
 * и добавляется в него путем присваивания переменной $additionalSettingsConfiguration
 * в основном конфиге
 * $config = array(
 *      ...
 *      'additional_settings' => $additionalSettingsConfiguration
 *      ...
 * );
 *
 * $additionalSettingsConfiguration получается следующим образом:
 * $additionalSettingsFile = $root . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'additionalSettings.php';
 * $additionalSettingsConfiguration = file_exists($additionalSettingsFile) ? require($additionalSettingsFile) : array();
 *
 * Так же тут устанавливаем специфичные для всех окружений, но для этого приложения
 * переменные PHP:
 *
 * ini_set('SOME_PARAM', 'SOME_VALUE');
 */

/**
 * Основная конфигурация консольного приложения
 */
$config = array(

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'common.helpers.*',
        'common.extensions.*',
        'common.models.*',
    ),

    // @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
    /*
    'modules'=>array(

    ),
    */

    // application components
    'components'=>array(

        /*
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=%%mysql_host%%;port=%%mysql_port%%;dbname=%%mysql_dbname%%',
            'emulatePrepare' => true,
            'username' => '%%mysql_username%%',
            'password' => '%%mysql_password%%',
            'charset' => 'utf8',
        ),
        */

    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    /*
    'params'=>array(

    ),
    */

);

return $config;
