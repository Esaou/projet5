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
    
    public function getLogin(string $username)
    {
        return $this->database->getDb()->prepare('SELECT * FROM users WHERE username = ?', [$username], null, true);
    }
}
