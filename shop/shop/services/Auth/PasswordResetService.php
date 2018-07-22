<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12.07.2018
 * Time: 12:16
 */

namespace shop\services\Auth;

use Yii;
use shop\forms\auth\PasswordResetRequestForm;
use shop\forms\auth\ResetPasswordForm;
use shop\repositories\UserRepository;
use shop\entities\User\User;
use yii\mail\MailerInterface;

class PasswordResetService
{
    private $mailer;
    private $users;
    public function __construct(UserRepository $users,MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->users = $users;
    }

    public function request(PasswordResetRequestForm $form): User
    {
        $user = $this->users->getByEmail($form->email);
        if (!$user->isActive()) {
            return \DomainException('User is not active');
        }
        $user->requestPasswordReset();
        $this->users->save($user);
        $sent=Yii::$app
            ->mailer
            ->compose(
                ['html' => 'auth/reset/confirm-html', 'text' => 'auth/reset/confirm-text'],
                ['user' => $user]
            )
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
        if (!$sent){
            throw new \RuntimeException('Sending error');
        }
        return $user;

    }
    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)){
           throw new \DomainException('Password reset token cannot be blank');
        }
        if (!$this->users->existsByPasswordResetToken($token)){
            throw new \DomainException('Wrong password reset token ');
        }
    }
    public function reset(string $token,ResetPasswordForm $form):void
    {
        $user = $this->users->getByPasswordResetToken($token);

        $user->resetPassword($form->password);
        $this->users->save($user);
    }

}