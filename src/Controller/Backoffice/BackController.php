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
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $this->view->renderAdmin(['template' => 'index', 'data' => ['countM' => $countMessage,'userId' => $userId,'activites' => $dataActivite,'professionnels' => $dataProfessionnel,'messages' => $dataMessage,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function pagesManager(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $contenuAccueil = $this->backManager->contenuAccueil();
        $contenuPresentation = $this->backManager->contenuPresentation();
        $contenuProjetSoin = $this->backManager->contenuProjetSoin();
        $contenuPartenaires = $this->backManager->contenuPartenaires();

        $this->view->renderAdmin(['template' => 'pagesManager', 'data' => ['presentation' => $contenuPresentation,'projetSoins' => $contenuProjetSoin,'partenaires' => $contenuPartenaires,'contenus' => $contenuAccueil,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function editAccueil(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $contenuAccueil = $this->backManager->contenuAccueil();

        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($contenu)) {
                $res = $postTable->updateAccueil($id, [
                
                    'contenu' => $contenu,

                ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }

        $post = $postTable->findAccueil($id);
        $form = new \App\Service\BootstrapForm($post);

        $this->view->renderAdmin(['template' => 'editAccueil', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function editPresentation(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $contenuAccueil = $this->backManager->contenuAccueil();

        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($contenu)) {
                $res = $postTable->updatePresentation($id, [
                
                    'contenu' => $contenu,

                ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }

        $post = $postTable->findPresentation($id);
        $form = new \App\Service\BootstrapForm($post);

        $this->view->renderAdmin(['template' => 'editPresentation', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function editProjetSoin(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $contenuAccueil = $this->backManager->contenuAccueil();

        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($contenu)) {
                $res = $postTable->updateProjetSoin($id, [
                
                    'contenu' => $contenu,

                ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }

        $post = $postTable->findProjetSoin($id);
        $form = new \App\Service\BootstrapForm($post);

        $this->view->renderAdmin(['template' => 'editProjetSoin', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function editPartenaires(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $contenuAccueil = $this->backManager->contenuAccueil();

        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($contenu)) {
                $res = $postTable->updatePartenaires($id, [
                
                    'contenu' => $contenu,

                ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }

        $post = $postTable->findPartenaires($id);
        $form = new \App\Service\BootstrapForm($post);

        $this->view->renderAdmin(['template' => 'editPartenaires', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function activitesManager(): void
    {
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataActivite = $this->backManager->allActivites();
        $this->view->renderAdmin(['template' => 'activitesManager', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'activites' => $dataActivite]]);
    }

    public function professionnelsManager(): void
    {
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataProfessionnels = $this->backManager->allProfessionnels();
        $this->view->renderAdmin(['template' => 'professionnelsManager', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'professionnels' => $dataProfessionnels]]);
    }

    public function addActivite(): void
    {
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
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

        if (!empty($_POST)) {
            if (!empty($nom) && !empty($titre)) {
                $res = $postTable->createActivite([
                    
                        'activite' => $nom,
                        'titre' => $titre,
                        'description' => $description

                    ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }

        $form = new \App\Service\BootstrapForm($_POST);

        $this->view->renderAdmin(['template' => 'addActivite', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }

    public function addProfessionnel(): void
    {
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        
        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
        
        $nom = $request->getPost()->get('nom');
        $activite = $request->getPost()->get('activite');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($nom) && !empty($activite)) {
                $res = $postTable->createProfessionnel([
                    
                        'nom' => $nom,
                        'id_activites' => $activite,

                    ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }

        $form = new \App\Service\BootstrapForm($_POST);
        $dataActivite = $this->backManager->allActivites();
        $this->view->renderAdmin(['template' => 'addProfessionnel', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'activites' => $dataActivite,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
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
            } else {
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
            $res = $postTable->deleteProfessionnel($proId);
            if ($res) {
                header("Location: index?action=professionnelsManager");
            } else {
                header("Location: index?action=professionnelsManager");
            }
        }
    }

    public function deleteMessage():void
    {
        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
        $msgId = $request->getGet()->get('id');
        

        if (!empty($_POST)) {
            $res = $postTable->deleteMessage($msgId);
            if ($res) {
                header("Location: index?action=messagesManager");
            } else {
                header("Location: index?action=messagesManager");
            }
        }
    }

    public function editActivite(): void
    {
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
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
        } else {
            $error = true;
        }

        $post = $postTable->find($id);
        $form = new \App\Service\BootstrapForm($post);
        $this->view->renderAdmin(['template' => 'editActivite', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function editProfessionnel(): void
    {
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
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
            if (!empty($activite) && !empty($nom)) {
                $res = $postTable->updateProfessionnel($id, [
                    
                        'nom' => $nom,
                        'id_activites' => $activite,

                    ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }

        $dataActivite = $this->backManager->allActivites();
        $post = $postTable->findPro($id);
        $form = new \App\Service\BootstrapForm($post);
        $this->view->renderAdmin(['template' => 'editProfessionnel', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'activites' => $dataActivite, 'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function messagesManager(): void
    {
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataMessages = $this->backManager->allMessages();
        $this->view->renderAdmin(['template' => 'messagesManager', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'messages' => $dataMessages]]);
    }

    public function showMessage(): void
    {
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
        $request = new Request();
        $id = $request->getGet()->get('id');
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataMessages = $this->backManager->showMessage($id);
        $this->view->renderAdmin(['template' => 'showMessage', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'messages' => $dataMessages]]);
    }

    public function profil(): void
    {
        $countMessage = $this->backManager->countMessages();
        $countProfessionnel = $this->backManager->countProfessionnels();
        $countActivites = $this->backManager->countActivites();
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
        $this->view->renderAdmin(['template' => 'profil', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'form' => $form,'errors' => $errors, 'error' => $error,'result'=>$result]]);
    }

    public function deconnecter():void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $auth->disconnect();
        header("Location: index?action=index");
    }
}
