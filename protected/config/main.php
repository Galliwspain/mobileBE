<?php
define('API_KEY', 'rubdmw6768');
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
            ),
        ),
        'request'=>array(
            'enableCsrfValidation'=>true,
        ),
    ),
);
/*/coords<long:\w+>/<lati:\w+>/raduis/<radius:\w+>*/
