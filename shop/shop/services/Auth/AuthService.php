<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 18.07.2018
 * Time: 15:25
 */

namespace shop\services\Auth;

use shop\entities\User;
use shop\forms\auth\LoginForm;
use shop\repositories\UserRepository;



class AuthService
{
    private  $users;

    public function __construct(UserRepository $users)
    {
        $this->users=$users;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->users->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() ||!$user->validatePassword($form->password)){
            throw new \DomainException('Undefined user or password.');

        }
        return $user;
    }

}