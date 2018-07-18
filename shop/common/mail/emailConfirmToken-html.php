<?php
use yii\helpers\Html;
/*@var $this yii\web\View */
/*@var $user shop\entities\User */
$confirmlink= Yii::$app->urlManager->createAbsoluteUrl(
    ['site/confirm', 'token' => $user->email_confirm_token
]);
?>
<div class="password-reset">
    <p>Hello <?=Html::encode($user->username) ?></p>
    <p>Follow the link below to confirm your email:</p>
    <p><?=Html::a(Html::encode($confirmlink),$confirmlink) ?></p>
</div>
