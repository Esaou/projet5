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

    public function login():void
    {
        $request = new \App\Service\Http\Request();
        $username = $request->getPost()->get('username');
        $password = $request->getPost()->get('password');
        $error = false;

        if (!empty($_POST)) {
            $auth = new \App\Service\Security\AccessControl($this->database->getInstance()->getDb());
            if ($auth->login($username, $password)) {
                header('Location: index?action=indexAdmin');
            } else {
                $error = true;
            }
        }
        $frontManager = new \App\Model\FrontManager($this->database);
        $dataForm = $frontManager->form();
        $dataActivites = $frontManager->activites();
        $view = new \App\View\View();
        $view->render(['template' => 'login', 'data' => ['forms' => $dataForm, 'error' => $error,'activites' => $dataActivites]]);
    }
    
    public function getLogin(string $username)
    {
        return $this->database->getDb()->prepare('SELECT * FROM users WHERE username = ?', [$username], null, true);
    }
}
