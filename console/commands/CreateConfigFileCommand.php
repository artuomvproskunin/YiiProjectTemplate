<?php

class CreateConfigFileCommand extends CConsoleCommand
{
    public function actionIndex($paramsfile)
    {

        if(file_exists($paramsfile)) {
            $filename = $paramsfile;
        }
        elseif(file_exists(getcwd().$paramsfile)) {
            $filename = getcwd().$paramsfile;
        }
        else {
            throw new Exception('Unknown params file');
        }

        $parameters = require($filename);

        require_once(Yii::getPathOfAlias('console') . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'ConfigTemplater.php');

        $template = new ConfigTemplater(file_get_contents('php://stdin'));

        $result = $template->render($parameters);
        file_put_contents('php://stdout', $result);

        return 0;
    }

}
