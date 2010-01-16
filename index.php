<?php

// change the following paths if necessary
// TODO: remove this out of here
switch( $_SERVER["SERVER_NAME"] )
{
    case 'storedbyu.imre.local':
                    $yii=dirname(__FILE__).'/../../yii/framework/yii.php';
                    break;
    default:
                    $yii=dirname(__FILE__).'/../yii/framework/yii.php';
}

require_once( dirname(__FILE__).'/protected/config/config.php' );

$config=dirname(__FILE__).'/protected/config/main.php';

require_once($yii);
Yii::createWebApplication($config)->run();
