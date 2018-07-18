<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp'
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'cookieValidationKey'=> $params['cookieValidationKey'],
        ],
        'user' => [
            'identityClass' => 'shop\entities\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'domain'=>$params['cookieDomain']
            ],

        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => '_session',
            'cookieParams'=>[
                'domain'=>$params['cookieDomain'],
                'httpOnly' => true

            ]
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
        'as access' => [
            'class' => 'yii\filters\AccessControl',
            'exept'=>['site/login','site/error'],
            'rules' => [
                    [
                    'allow' => true,
                    'roles' => ['@'],
                    ],
            ],
        ],

        'backendUrlManager'=> require __DIR__ . '/../../backend/config/uralManager.php',
        'frontendUrlManager' => require __DIR__ . '/uralManager.php',
        'urlManager' => function (){
            return Yii::$app->get('frontendUrlManager');
        },

    ],
    'params' => $params,
];
