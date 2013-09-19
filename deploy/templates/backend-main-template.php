<?php
/**
 * main.php
 *
 * @author: artuom proskunin <artuomv.proskunin@gmail.com>
 */

/**
 * Настройки РНР
 * Могут быть переопределенны в в main-ENVIRONMENT.php см. конец файла
 */
date_default_timezone_set('Europe/Moscow');
error_reporting(0);
ini_set('display_errors', false);

/**
 * Базовые дирректории
 */
$backendConfigDir = dirname(__FILE__);
$root = $backendConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

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
 * Устанавливаем некоторые алиасы путей, для удобства их использования и для
 * системных нужд.
 *
 * Все прочие системные алиасы будут относительно установленного 'root'
 */
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('common', $root . DIRECTORY_SEPARATOR . 'common');
Yii::setPathOfAlias('backend', $root . DIRECTORY_SEPARATOR . 'backend');
Yii::setPathOfAlias('www', $root. DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'www');

/**
 * Основной конфигурационный файл приложения
 */
$config = array(

    // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
    'basePath' => 'backend',

    'name' => 'WebApplication',

    'sourceLanguage' => 'en',

    // @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
    'language' => 'ru',

    // preload components required before running applications
    // @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
    'preload'=>array('log'),

    // autoloading model and component classes
    // @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
    'import'=>array(
        'backend.components.*',
        'backend.models.*',
        'backend.extensions.*',
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
    'components' => array(
        'user' => array(

        ),

        'assetManager' => array(
            'linkAssets' => true
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '/',
            'rules'=>array(
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),

        /*
        'bootstrap' => array(
            'class' => 'common.extensions.bootstrap.components.Bootstrap',
            'responsiveCss' => false,
        ),
        */

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

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info, error, warning',
                    'maxFileSize' => '10240',
                    'maxLogFiles' => '25',
                    'logFile' => 'application.log',
                ),
            )
        ),

        /*
        'errorHandler' => array(
            // @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
            'errorAction'=>'site/error'
        ),
        */
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'adminEmail' => '%%admin_email%%',
    ),

);

/**
 * Определяем среду выполнения приложения. Такая среда (вследствие некой ограниченности yii в данной области) задается через
 * переменную среды APPLICATION_ENV веб-сервером (apachе или nginx):
 * При запуске через связку nginx + php-fpm нужно передавать переменную среды с помощью директивы fastcgi_param, например:
 * <pre>
 * fastcgi_param APPLICATION_ENV stage;
 * </pre>
 * При запуске через связку nginx + apache следует воспользоваться директивой SETENV
 *
 * @link http://habrahabr.ru/post/146473/
 */
$environment = isset($_SERVER['APPLICATION_ENV']) ? $_SERVER['APPLICATION_ENV'] : 'production';

if($environment !== 'production') {

    // Проверяем наличие файла конфигурации для среды исполнения и необходимость его подключения
    $localConfigFile = $backendConfigDir.'/main-'.$environment.'.php';
    if(file_exists($localConfigFile)) {
        $config = CMap::mergeArray(
            $config,
            require($localConfigFile)
        );
    }
}

return $config;
