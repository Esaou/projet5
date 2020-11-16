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
        $dataProfessionnel = $this->backManager->allProfessionnels();
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

    public function addActivite(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        
        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
        
        $nom = $request->getPost()->get('activite');
        $titre = $request->getPost()->get('titre');
        $description = $request->getPost()->getWithoutHtml('description');
        
        $error = false;
        $result = false;

        if(!empty($_POST)){
            if (!empty($nom) && !empty($titre)) {
                    $res = $postTable->createActivite([
                    
                        'activite' => $nom,
                        'titre' => $titre,
                        'description' => $description

                    ]);
                    if ($res) {
                        $result = true;
                    }
            }else {
                $error = true;
            }
        }

        $form = new \App\Service\BootstrapForm($_POST);

        $this->view->renderAdmin(['template' => 'addActivite', 'data' => ['result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }

    public function addProfessionnel(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        
        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
        
        $nom = $request->getPost()->get('nom');
        $activite = $request->getPost()->get('activite');
        
        $error = false;
        $result = false;

        if(!empty($_POST)){
            if (!empty($nom)) {
                    $res = $postTable->createProfessionnel([
                    
                        'nom' => $nom,
                        'id_activites' => $activite,

                    ]);
                    if ($res) {
                        $result = true;
                    }
            }else {
                $error = true;
            }
        }

        $form = new \App\Service\BootstrapForm($_POST);
        $dataActivite = $this->backManager->allActivites();
        $this->view->renderAdmin(['template' => 'addProfessionnel', 'data' => ['activites' => $dataActivite,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }

    public function deleteActivite():void
    {
        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
        $activiteId = $request->getGet()->get('id');
        

        if (!empty($_POST)) {
                $result = $postTable->deleteActivite($activiteId);
                if ($result) {
                    header("Location: index?action=activitesManager");
                }else{
                    header("Location: index?action=activitesManager");
                }
        }
    }

    public function deleteProfessionnel():void
    {
        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
        $proId = $request->getGet()->get('id');
        

        if (!empty($_POST)) {
                $result = $postTable->deleteProfessionnel($proId);
                if ($result) {
                    header("Location: index?action=professionnelManager");
                }else{
                    header("Location: index?action=professionnelManager");
                }
        }
    }

    public function editActivite(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        
        $postTable = $this->database->getInstance()->getTable('BackManager');
        
        $request = new Request();

        $nom = $request->getPost()->get('activite');
        $titre = $request->getPost()->get('titre');
        $description = $request->getPost()->getWithoutHtml('description');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
                $res = $postTable->updateActivite($id, [
                
                    'activite' => $nom,
                    'titre' => $titre,
                    'description' => $description

                ]);
                if ($res) {
                    $result = true;
                }
        }else {
            $error = true;
        }

        $post = $postTable->find($id);
        $form = new \App\Service\BootstrapForm($post);
        $this->view->renderAdmin(['template' => 'editActivite', 'data' => ['result' => $result,'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function editProfessionnel(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        
        $postTable = $this->database->getInstance()->getTable('BackManager');
        
        $request = new Request();

        $nom = $request->getPost()->get('nom');
        $activite = $request->getPost()->get('activite');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
                $res = $postTable->updateProfessionnel($id, [
                
                    'nom' => $nom,
                    'id_activites' => $activite,

                ]);
                if ($res) {
                    $result = true;
                }
        }else {
            $error = true;
        }

        $dataActivite = $this->backManager->allActivites();
        $post = $postTable->findPro($id);
        $form = new \App\Service\BootstrapForm($post);
        $this->view->renderAdmin(['template' => 'editProfessionnel', 'data' => ['result' => $result,'activites' => $dataActivite, 'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function messagesManager(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataMessages = $this->backManager->allMessages();
        $this->view->renderAdmin(['template' => 'messagesManager', 'data' => ['userId' => $userId,'messages' => $dataMessages]]);
    }

    public function showMessage(): void
    {
        $request = new Request();
        $id = $request->getGet()->get('id');
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataMessages = $this->backManager->showMessage($id);
        $this->view->renderAdmin(['template' => 'showMessage', 'data' => ['userId' => $userId,'messages' => $dataMessages]]);
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
