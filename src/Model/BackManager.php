<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;
use App\Service\Http\Request;

class BackManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    // Méthodes pour chaque page backoffice

    public function getIndex(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataActivite = $table->lastActivite();
        $dataProfessionnel = $table->lastProfessionnel();
        $dataMessage = $table->lastMessage();
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'index', 'data' => ['countM' => $countMessage,'userId' => $userId,'activites' => $dataActivite,'professionnels' => $dataProfessionnel,'messages' => $dataMessage,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getProfil(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $request = new Request();
        
        $username = $request->getPost()->get('Username');
        $password = $request->getPost()->get('Password');
        $confirm = $request->getPost()->get('Confirm');
        $id = $request->getGet()->get('id');
        
        $users = $this->database->getDb()->query("SELECT * FROM users ORDER BY id DESC", 'App\Models\BackOffice');
        
        $errors = false;
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($username) && !empty($password) && !empty($confirm)) {
                if ($password === $confirm) {
                    $table->updateProfil($id, [
                    
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
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'profil', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'form' => $form,'errors' => $errors, 'error' => $error,'result'=>$result]]);
    }

    public function getActivitesManager(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataActivite = $table->allActivites();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'activitesManager', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'activites' => $dataActivite]]);
    }

    public function getProfessionnelsManager(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataProfessionnels = $table->allProfessionnels();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'professionnelsManager', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'professionnels' => $dataProfessionnels]]);
    }

    public function getMessagesManager(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataMessages = $table->allMessages();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'messagesManager', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'messages' => $dataMessages]]);
    }

    public function getPagesManager(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $contenuAccueil = $table->contenuAccueil();
        $contenuPresentation = $table->contenuPresentation();
        $contenuProjetSoin = $table->contenuProjetSoin();
        $contenuPartenaires = $table->contenuPartenaires();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'pagesManager', 'data' => ['presentation' => $contenuPresentation,'projetSoins' => $contenuProjetSoin,'partenaires' => $contenuPartenaires,'contenus' => $contenuAccueil,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getShowMessage(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $request = new Request();
        $id = $request->getGet()->get('id');
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataMessages = $table->showMessage($id);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'showMessage', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'messages' => $dataMessages]]);
    }

    public function getEditAccueil(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $contenuAccueil = $table->contenuAccueil();

        $request = new Request();
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($contenu)) {
                $res = $table->updateAccueil($id, [
                
                    'contenu' => $contenu,

                ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }

        $post = $table->findAccueil($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editAccueil', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getEditPresentation(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $contenuAccueil = $table->contenuAccueil();

        $request = new Request();
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($contenu)) {
                $res = $table->updatePresentation($id, [
                
                    'contenu' => $contenu,

                ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }

        $post = $table->findPresentation($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editPresentation', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getEditProjetSoin(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $contenuAccueil = $table->contenuAccueil();

        $request = new Request();
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($contenu)) {
                $res = $table->updateProjetSoin($id, [
                
                    'contenu' => $contenu,

                ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }

        $post = $table->findProjetSoin($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editProjetSoin', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getEditPartenaires(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $contenuAccueil = $table->contenuAccueil();

        $request = new Request();
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($contenu)) {
                $res = $table->updatePartenaires($id, [
                
                    'contenu' => $contenu,

                ]);
                if ($res) {
                    $result = true;
                }
            } else {
                $error = true;
            }
        }
        $view = new \App\View\View();
        $post = $table->findPartenaires($id);
        $form = new \App\Service\BootstrapForm($post);

        $view->renderAdmin(['template' => 'editPartenaires', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getEditActivite(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        
        $request = new Request();

        $nom = $request->getPost()->get('activite');
        $titre = $request->getPost()->get('titre');
        $description = $request->getPost()->getWithoutHtml('description');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            $res = $table->updateActivite($id, [
                
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

        $post = $table->find($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editActivite', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function getEditProfessionnel(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        
        $request = new Request();

        $nom = $request->getPost()->get('nom');
        $activite = $request->getPost()->get('activite');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;
        if (!empty($_POST)) {
            if (!empty($activite) && !empty($nom)) {
                $res = $table->updateProfessionnel($id, [
                    
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

        $dataActivite = $table->allActivites();
        $post = $table->findPro($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editProfessionnel', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'activites' => $dataActivite, 'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function getAddActivite(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        
        $request = new Request();
        
        $nom = $request->getPost()->get('activite');
        $titre = $request->getPost()->get('titre');
        $description = $request->getPost()->getWithoutHtml('description');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($nom) && !empty($titre)) {
                $res = $table->createActivite([
                    
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
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'addActivite', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }

    public function getAddProfessionnel(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();

        $request = new Request();
        
        $nom = $request->getPost()->get('nom');
        $activite = $request->getPost()->get('activite');
        
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (!empty($nom) && !empty($activite)) {
                $res = $table->createProfessionnel([
                    
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
        $dataActivite = $table->allActivites();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'addProfessionnel', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'activites' => $dataActivite,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }
}
