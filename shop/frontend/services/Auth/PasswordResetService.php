<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12.07.2018
 * Time: 12:16
 */

namespace frontend\services\Auth;

use Yii;
use frontend\forms\PasswordResetRequestForm;
use frontend\forms\ResetPasswordForm;
use common\entities\User;

class PasswordResetService
{
    private $supportEmail;
    public function __construct($supportEmail)
    {
        $this->supportEmail = $supportEmail;
    }

    public function request(PasswordResetRequestForm $form)
    {
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $form->email,
        ]);
        if (!$user) {
            return \DomainException('User is not found');
        }
        $user->requestPasswordReset();
        if (!$user->save()){
            throw new \RuntimeException('Saving error');
        }
        $sent=Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
        if (!$sent){
            throw new \RuntimeException('Sending error');
        }
        return $sent;

    }
    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)){
           throw new \DomainException('Password reset token cannot be blank');
        }
        if (!User::findByPasswordResetToken($token)){
            throw new \DomainException('Wrong password reset token ');
        }
    }
    public function reset(string $token,ResetPasswordForm $form):void
    {
        $user = User::findByPasswordResetToken($token);
        if (!$user){
            throw new \DomainException('User is not found ');
        }
        $user->resetPassword($form->password);
        if (!$user->save()){
            throw new \RuntimeException('Saving error');
        }
    }

}