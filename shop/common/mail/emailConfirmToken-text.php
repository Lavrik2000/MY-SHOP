<?php
use yii\helpers\Html;
/*@var $this yii\web\View */
/*@var $user shop\entities\User\User */
$confirmlink= Yii::$app->urlManager->createAbsoluteUrl(
    ['site/confirm', 'token' => $user->email_confirm_token
    ]);
?>

    Hello <?=Html::encode($user->username) ?>
    Follow the link below to confirm your email:
    <?=$confirmlink ?>

