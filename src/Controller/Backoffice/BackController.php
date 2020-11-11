<?php

declare(strict_types=1);

namespace App\Controller\Backoffice;

use App\Model\BackManager;
use App\Model\CommentManager;
use App\Model\FrontManager;
use App\Service\Database;
use App\Service\Http\Request;
use App\Service\Security\AccessControl;
use App\View\View;

class BackController
{
    private FrontManager $postManager;
    private Database $database;
    private BackManager $backManager;
    private View $view;

    public function __construct(FrontManager $postManager, BackManager $backManager, View $view, Database $database)
    {
        $this->postManager = $postManager;
        $this->view = $view;
        $this->backManager = $backManager;
        $this->database = $database;

        $app = $this->database->getInstance();

        $auth = new \App\Service\Security\AccessControl($app->getDb());

        if (!$auth->logged()) {
            header('Location: index?action=forbidden');
        }
    }

    public function index(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataActivite = $this->backManager->lastActivite();
        $dataProfessionnel = $this->backManager->lastProfessionnel();
        $dataMessage = $this->backManager->lastMessage();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $this->view->renderAdmin(['template' => 'index', 'data' => ['userId' => $userId,'activites' => $dataActivite,'professionnels' => $dataProfessionnel,'messages' => $dataMessage,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function activitesManager(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataActivite = $this->backManager->allActivites();
        $this->view->renderAdmin(['template' => 'activitesManager', 'data' => ['userId' => $userId,'activites' => $dataActivite]]);
    }

    public function professionnelsManager(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataProfessionnels = $this->backManager->allProfessionnels();
        $this->view->renderAdmin(['template' => 'professionnelsManager', 'data' => ['userId' => $userId,'professionnels' => $dataProfessionnels]]);
    }

    public function messagesManager(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataMessages = $this->backManager->allMessages();
        $this->view->renderAdmin(['template' => 'messagesManager', 'data' => ['userId' => $userId,'messages' => $dataMessages]]);
    }

    public function profil(): void
    {
        $request = new Request();
        
        $username = $request->getPost()->get('Username');
        $password = $request->getPost()->get('Password');
        $confirm = $request->getPost()->get('Confirm');
        $id = $request->getGet()->get('id');
        
        $users = $this->database->getDb()->query("SELECT * FROM users ORDER BY id DESC", 'App\Models\BackOffice');
        
        $errors = false;
        $error = false;
        $result = false;
        
        $postTable = $this->database->getInstance()->getTable('BackManager');

        if (!empty($_POST)) {
            if (!empty($username) && !empty($password) && !empty($confirm)) {
                if ($password === $confirm) {
                    $postTable->updateProfil($id, [
                    
                        'username' => $username,
                        'password' => sha1($confirm)

                    ]);
                    $result = true;
                } else {
                    $errors = true;
                }
            } else {
                $error = true;
            }
        }

        $form = new \App\Service\BootstrapForm();
        $this->view->renderAdmin(['template' => 'profil', 'data' => ['form' => $form,'errors' => $errors, 'error' => $error,'result'=>$result]]);
    }

    public function deconnecter():void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $auth->disconnect();
        header("Location: index?action=index");
    }
}
