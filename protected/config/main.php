<?php

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
            'rules'=>array(
                'hello/<query:\w+>'=>'Mobile/minicards',
            ),
        ),
        'request'=>array(
            'enableCsrfValidation'=>true,
        ),
    ),
);
