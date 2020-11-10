<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

class UsersManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function login(): void
    {
        $request = new \App\Service\Http\Request();
        $tokenGet = $request->getPost()->get('token');
        $tokenSession = $request->getSession()->get('token');
        $username = $request->getPost()->get('username');
        $password = $request->getPost()->get('password');

        if (!empty($_POST)) {
            $auth = new \App\Service\Security\AccessControl($this->database->getInstance()->getDb());
            if ($auth-> login($username, $password)) {
                header('Location: index?action=indexAdmin');
            } else {
                $errors = true;
            }
        }
    }
    
    public function getLogin(string $username)
    {
        return $this->database->getDb()->prepare('SELECT * FROM users WHERE username = ?', [$username], null, true);
    }
}
