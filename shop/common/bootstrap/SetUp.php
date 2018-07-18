<?php

namespace common\bootstrap;

use frontend\services\Auth\PasswordResetService;
use frontend\services\Contact\ContactService;
use common\repositories\UserRepository;
use yii\base\BootstrapInterface;
use Yii;
use yii\mail\MailerInterface;


class SetUp implements BootstrapInterface
{


    public function bootstrap($app)
    {
        $container=\Yii::$container;


        $container->setSingleton(MailerInterface::class, function ()use ($app){
            return $app->mailer;

        });

        $container->setSingleton(ContactService::class, [],
            [
                 Yii::$app->params['adminEmail'],
            ]);

// использовать, если класс с большим количеством настроек в конструкторе
//        $container->setSingleton(PasswordResetService::class, function () use($app){
//            return new PasswordResetService([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot']);
//        });
    }
}