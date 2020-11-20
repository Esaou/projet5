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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');

        $username = $request->getPost()->get('username');
        $password = $request->getPost()->get('password');
        $error = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                $auth = new \App\Service\Security\AccessControl($this->database->getInstance()->getDb());
                if ($auth->login($username, $password)) {
                    header('Location: index?action=indexAdmin');
                } else {
                    $error = true;
                }
            } else {
                $tokenError = true;
            }
        }
        $request->getSession()->set('token', $token);
        $frontManager = new \App\Model\FrontManager($this->database);
        $dataForm = $frontManager->form();
        $dataActivites = $frontManager->activites();
        $view = new \App\View\View();
        $view->render(['template' => 'login', 'data' => ['token' => $token, 'tokenError' => $tokenError,'forms' => $dataForm, 'error' => $error,'activites' => $dataActivites]]);
    }
    
    public function getLogin(string $username)
    {
        return $this->database->getDb()->prepare('SELECT * FROM users WHERE username = ?', [$username], null, true);
    }
}
