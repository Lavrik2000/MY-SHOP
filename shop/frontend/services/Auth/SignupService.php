<?php
namespace frontend\services\Auth;

use common\entities\User;
use frontend\forms\SignupForm;

class SignupService
{
    public function signup(SignupForm $form):User
    {
//        if (User::find()->andWhere(['username'=>$form->username])){
//            throw new \DomainException('Username already exist');
//        }
//        if (User::find()->andWhere(['email'=>$form->email])){
//            throw new \DomainException('Email already exist');
//        }
        $user = User::signup(
            $form->username,
            $form->email,
            $form->password
        );
        if (!$user->save()){
            throw new\RuntimeException('Saving error.');
        }
        return $user;
    }

}