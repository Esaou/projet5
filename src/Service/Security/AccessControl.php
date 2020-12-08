<?php

declare(strict_types=1);

namespace App\Service\Security;

use \PDO;
use App\Model\UsersManager;
use App\Service\Database;
use App\Service\Http\Request;

class AccessControl
{
    private $db;
    private $request;

    public function __construct(Database $db)
    {
        $this->request = new Request();
        $this->db = $db;
    }

    public function login(string $username, string $password):bool
    {
        $instance = new UsersManager($this->db);
        $user = $instance->getLogin($username);
        if ($user && password_verify($password, $user->password)) {
            $this->request->getSession()->set('auth', $user->id);
            return true;
        }
        return false;
    }

    public static function logged():bool
    {
        $request = new Request();
        $isConnect = $request->getSession()->get('auth');
        return isset($isConnect);
    }

    public static function disconnect(): void
    {
        $request = new Request();
        $isConnect = $request->getSession()->get('auth');
        $isToken = $request->getSession()->get('token');
        if (isset($isConnect)) {
            unset($isToken);
            session_destroy();
        }
    }

    public static function getUserId()
    {
        $request = new Request();
        $isConnect = $request->getSession()->get('auth');

        if (static::logged()) {
            return $isConnect;
        }

        return false;
    }
}
