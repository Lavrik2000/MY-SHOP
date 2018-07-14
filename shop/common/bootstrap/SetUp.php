<?php

namespace common\bootstrap;
use frontend\services\Auth\PasswordResetService;
use yii\base\Application;
use yii\base\BootstrapInterface;
use Yii;


class SetUp implements BootstrapInterface
{


    public function bootstrap($app)
    {
        $container=\Yii::$container;
        $container->setSingleton(PasswordResetService::class, [],
            [[Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot']]);

// использовать, если класс с большим количеством настроек в конструкторе
//        $container->setSingleton(PasswordResetService::class, function () use($app){
//            return new PasswordResetService([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot']);
//        });
    }
}