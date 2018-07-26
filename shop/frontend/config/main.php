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
            'identityClass' => 'shop\entities\User\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'domain'=>$params['cookieDomain']
            ],
            'loginUrl' => ['auth/auth/login'],
            //'baseAuthUrl' => ['auth/network/auth'],

        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '2083167995091128',
                    'clientSecret' => 'ffb7a0c8111d55de971cbc128eabc247',
                ],
                'vk' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '6642513',
                    'clientSecret' => 'unSu84gkIgYuY7UJGOmU',
                ],
                // etc.
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

        'backendUrlManager'=> require __DIR__ . '/../../backend/config/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/urlManager.php',
        'urlManager' => function (){
            return Yii::$app->get('frontendUrlManager');
        },

    ],
    'params' => $params,
];
