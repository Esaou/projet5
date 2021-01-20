<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Model\FrontManager;
use App\Model\UsersManager;
use App\Service\Database;
use App\Service\Http\Request;
use App\View\View;

class UsersController
{
    private UsersManager $usersManager;
    private FrontManager $frontManager;
    private Database $database;
    private View $view;
    private Request $request;

    public function __construct(UsersManager $usersManager, FrontManager $frontManager, View $view, Database $database, Request $request)
    {
        $this->view = $view;
        $this->database = $database;
        $this->frontManager = $frontManager;
        $this->usersManager = $usersManager;
        $this->request = $request;
    }

    public function login():void
    {
        $this->request = new \App\Service\Http\Request();
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');

        $username = $this->request->getPost()->get('username');
        $password = $this->request->getPost()->get('password');
        
        $error = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                $auth = new \App\Service\Security\AccessControl($this->database->getInstance()->getDb());
                if (!empty($username) and !empty($password) and $auth->login($username, $password)) {
                    header('Location: index?action=indexAdmin');
                    exit();
                }
                $error = true;
            } else {
                $tokenError = true;
            }
        }
        $this->request->getSession()->set('token', $token);
        
        $dataForm = $this->frontManager->form();
        $lastActivite = $this->frontManager->lastActivite();
        $dataActivites = $this->frontManager->activites();

        $this->view->render(['template' => 'login', 'data' => ['lastActivite' => $lastActivite,'token' => $token, 'tokenError' => $tokenError,'forms' => $dataForm, 'error' => $error,'activites' => $dataActivites]]);
    }
}
