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
    private FrontManager $postManager;
    private Database $database;
    private View $view;

    public function __construct(UsersManager $usersManager, FrontManager $postManager, View $view, Database $database)
    {
        $this->view = $view;
        $this->database = $database;
        $this->postManager = $postManager;
        $this->usersManager = $usersManager;
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
        $dataForm = $this->postManager->form();
        $dataActivites = $this->postManager->activites();
        $this->view->render(['template' => 'login', 'data' => ['forms' => $dataForm, 'error' => $error,'activites' => $dataActivites]]);
    }
}
