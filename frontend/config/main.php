<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'defaultRoute' => 'home',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
    	 'view' => [
	        'theme' => [
	            'pathMap' => ['@app/views' => '@app/themes/FlatLab'],
	            'baseUrl' => '@web/themes',
	        ],
	    ],
	    'request' => array(
	        'enableCsrfValidation' => false,
	    ),
    	'urlManager' => [
    	    'scriptUrl'=>'/index.php',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '<controller:(post|comment)>/<id:\d+>/<action:(create|update|delete)>' => '<controller>/<action>',
    			'<controller:(post|comment)>/<id:\d+>' => '<controller>/view',
    			'<controller:(post|comment)>s' => '<controller>/index',
            ],
         ], 
         'utility' => [
		        'class' => 'app\components\utility'
		  ],
				 
				 
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                      'class' => 'yii\authclient\clients\Facebook',
                      'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                      'clientId' => '1465522503771203',
                      'clientSecret' => '147cc6e449663f5264be18a95557cc01',
                    ],
                    'google' => [
                        'class' => 'yii\authclient\clients\GoogleOAuth',
                        //'clientId' => '58452093916-dcpr78m7c25u8pu7enmlq9l6mghpr8pg.apps.googleusercontent.com',
                        //'clientSecret' => 'c7qem8k-waOxVuNm52ffwt3V',
                        //'returnUrl' =>  'http://dev.web.rapidfy.com/rapidfy-web-nm/frontend/web/index.php?r=site/auth&authclient=google',
                        
                        'clientId' => '58452093916-8rlvq29sa2bpu2s4veqvfd6pqg1pbbko.apps.googleusercontent.com',
                        'clientSecret' => 'XuCWXWe6jJ3QITL5k3eB2SFd',
                        'returnUrl' =>  'http://dev2.web.rapidfy.com/home/auth?authclient=google',
					
                    ],
                ],
        ],
    ],
    'params' => $params,
];
