<?php
use yii\helpers\Html;
/*@var $this yii\web\View */
/*@var $user common\entities\User */
$confirmlink= Yii::$app->urlManager->createAbsoluteUrl(
    ['site/confirm', 'token' => $user->email_confirm_token
    ]);
?>

    Hello <?=Html::encode($user->username) ?>
    Follow the link below to confirm your email:
    <?=$confirmlink ?>

