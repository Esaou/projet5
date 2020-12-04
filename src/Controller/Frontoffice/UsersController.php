<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Model\FrontManager;
use App\Model\UsersManager;
use App\Service\Database;
use App\View\View;

class UsersController
{
    private UsersManager $usersManager;
    private FrontManager $frontManager;
    private Database $database;
    private View $view;

    public function __construct(UsersManager $usersManager, FrontManager $frontManager, View $view, Database $database)
    {
        $this->view = $view;
        $this->database = $database;
        $this->frontManager = $frontManager;
        $this->usersManager = $usersManager;
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
                    exit();
                }
                $error = true;
            } else {
                $tokenError = true;
            }
        }
        $request->getSession()->set('token', $token);
        
        $dataForm = $this->frontManager->form();
        $dataActivites = $this->frontManager->activites();

        $this->view->render(['template' => 'login', 'data' => ['token' => $token, 'tokenError' => $tokenError,'forms' => $dataForm, 'error' => $error,'activites' => $dataActivites]]);
    }
}
