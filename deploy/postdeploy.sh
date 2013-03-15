#!/bin/bash

CURDIR=$(pwd)
TMP_DIR=./tmp
ENVIRONMENT=$1
ENVIRONMENT_PARAMS_DIR=$2
YIIC_PATH=../yiic
ERRORS=0

cd $(dirname $0)

function parametrizeConfig {
    TEMPLATE_FILE=$1
    OUTPUT_FILE=$2
    $YIIC_PATH createconfigfile --paramsfile=$ENVIRONMENT_PARAMS_DIR/$ENVIRONMENT.php < $TEMPLATE_FILE > $OUTPUT_FILE
    ERRORS=$?

    if [[ $ERRORS = 0 ]]
    then
        GREP_ERROR=$(grep -e "%%\(.*\)%%" $OUTPUT_FILE)
        if [[ GREP_ERROR = 0 ]]
        then
            ERRORS=1
        fi
    fi
}

function errorExit {
    echo $1
    cd $CURDIR
    exit 1
}

if [ -z $ENVIRONMENT ]
then
    errorExit "You must set the environment"
fi

if [ -z $ENVIRONMENT_PARAMS_DIR ]
then
    ENVIRONMENT_PARAMS_DIR="./environments/"
fi

if [ ! -e "$ENVIRONMENT_PARAMS_DIR/$ENVIRONMENT.php" ]
then
    errorExit "File $ENVIRONMENT_PARAMS_DIR/$ENVIRONMENT.php does not exist"
fi

parametrizeConfig templates/frontend-main-template.php $TMP_DIR/frontend-main.php
parametrizeConfig templates/frontend-main-devel-template.php $TMP_DIR/frontend-main-devel.php
parametrizeConfig templates/console-main-template.php $TMP_DIR/console-main.php
parametrizeConfig templates/backend-main-template.php $TMP_DIR/backend-main.php
parametrizeConfig templates/backend-main-devel-template.php $TMP_DIR/backend-main-devel.php

if [[ $ERRORS = 1 ]]
then
    errorExit "Error occured during config templates processing. Preconfigured files available in $TMP_DIR folder"
fi

mv $TMP_DIR/frontend-main.php ../frontend/config/main.php
mv $TMP_DIR/frontend-main-devel.php ../frontend/config/main-devel.php
mv $TMP_DIR/console-main.php ../console/config/main.php
mv $TMP_DIR/backend-main.php ../backend/config/main.php
mv $TMP_DIR/backend-main-devel.php ../backend/config/main-devel.php


mkdir ../frontend/runtime
mkdir ../frontend/www/assets
mkdir ../console/runtime
mkdir ../backend/runtime
mkdir ../backend/www/assets

chmod -R 777 ../frontend/runtime
chmod -R 777 ../frontend/www/assets
chmod -R 777 ../console/runtime
chmod -R 777 ../backend/runtime
chmod -R 777 ../backend/www/assets

cd $CURDIR
