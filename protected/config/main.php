<?php
define('API_KEY', 'rubdmw6768');
date_default_timezone_set('Asia/Novosibirsk');
return array(
    'name'=>'mobileBE',
    'defaultController'=>'Mobile',
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),
    'components'=>array(
        'urlManager'=>array(
            'urlFormat'=>'path',
	    'showScriptName'=>false,
            'rules'=>array(
		'' => 'Mobile/index',
                'api/search/companies/<query:\w+>/page/<page:\w+>/coords/<long>/<lati>/radius/<radius>'=>'Mobile/minicards',
                'api/search/markers/<query:\w+>/coords/<long>/<lati>/radius/<radius>'=>'Mobile/markers',
                'api/minicompany/<cid:\w+>'=>'Mobile/minicompany',
            ),
        ),
        'request'=>array(
            'enableCsrfValidation'=>true,
        ),
    ),
);
/*/coords<long:\w+>/<lati:\w+>/raduis/<radius:\w+>*/
