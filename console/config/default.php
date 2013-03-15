<?php
/**
 * default.php
 *
 * Файл содержит базовые настройки.
 *
 */

/**
 * Настройки РНР
 * Могут быть переопределенны в в main-ENVIRONMENT.php см. конец файла
 */
date_default_timezone_set('Europe/Moscow');

/**
 * Базовые дирректории
 */
$consoleConfigDir = dirname(__FILE__);
$root = $consoleConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

/**
 * Устанавливаем некоторые алиасы путей, для удобства их использования и для
 * системных нужд.
 *
 * Все прочие системные алиасы будут относительно установленного 'root'
 */
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('console', $root . DIRECTORY_SEPARATOR . 'console');
Yii::setPathOfAlias('common', $root . DIRECTORY_SEPARATOR . 'common');

$mainConfigurationFile = $root . DIRECTORY_SEPARATOR . 'console' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php';
$mainConfiguration = file_exists($mainConfigurationFile) ? require($mainConfigurationFile) : array();

/**
 * Основной конфигурационный файл приложения
 */
$config = CMap::mergeArray(
    array(
        // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
        'basePath' => 'console',
    ),
    $mainConfiguration
);

/**
 * Определяем среду выполнения приложения. Такая среда (вследствие некой огланиченность yii в данной области) задается через
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
    $localConfigFile = $consoleConfigDir.'/main-'.$environment.'.php';
    if(file_exists($localConfigFile)) {
        $config = CMap::mergeArray(
            $config,
            require($localConfigFile)
        );
    }
}

/**
 * Настройки фреймворка по умолчанию, если иные не указанны в main-ENVIRONMENT.php
 */
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 0);

return $config;
