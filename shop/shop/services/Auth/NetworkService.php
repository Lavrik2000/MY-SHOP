<?php
/**
 * Created by PhpStorm.
 * User: Гномъ-Наследникъ
 * Date: 24.07.2018
 * Time: 10:31
 */

namespace shop\services\Auth;

use shop\entities\User\User;
use shop\repositories\UserRepository;


class NetworkService
{
    private $users;

    public  function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth($network,$identity):User
    {
        if ($user = $this->users->findByNetworkIdentity($network,$identity)) {
            return $user;
        }
        $user = User::signupByNetwork($network, $identity);
        $this->users->save($user);
        return $user;

    }
}