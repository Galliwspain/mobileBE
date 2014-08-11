<?php

require_once('vendor/yiisoft/yii/framework/yii.php');

$configFile='./protected/config/main.php';

Yii::createWebApplication($configFile)->run();
