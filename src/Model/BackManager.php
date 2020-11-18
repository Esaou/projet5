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
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataActivite = $this->lastActivite();
        $dataProfessionnel = $this->lastProfessionnel();
        $dataMessage = $this->lastMessage();
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'index', 'data' => ['countM' => $countMessage,'userId' => $userId,'activites' => $dataActivite,'professionnels' => $dataProfessionnel,'messages' => $dataMessage,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getPagesManager(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
        $contenuAccueil = $this->contenuAccueil();
        $contenuPresentation = $this->contenuPresentation();
        $contenuProjetSoin = $this->contenuProjetSoin();
        $contenuPartenaires = $this->contenuPartenaires();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'pagesManager', 'data' => ['presentation' => $contenuPresentation,'projetSoins' => $contenuProjetSoin,'partenaires' => $contenuPartenaires,'contenus' => $contenuAccueil,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getActivitesManager(): void
    {
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataActivite = $this->allActivites();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'activitesManager', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'activites' => $dataActivite]]);
    }

    public function getProfessionnelsManager(): void
    {
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataProfessionnels = $this->allProfessionnels();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'professionnelsManager', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'professionnels' => $dataProfessionnels]]);
    }

    public function getMessagesManager(): void
    {
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataMessages = $this->allMessages();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'messagesManager', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'messages' => $dataMessages]]);
    }

    public function getShowMessage(): void
    {
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
        $request = new Request();
        $id = $request->getGet()->get('id');
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataMessages = $this->showMessage($id);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'showMessage', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'messages' => $dataMessages]]);
    }

    public function getEditAccueil(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
        $contenuAccueil = $this->contenuAccueil();

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
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editAccueil', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getEditPresentation(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
        $contenuAccueil = $this->contenuAccueil();

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
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editPresentation', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getEditProjetSoin(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
        $contenuAccueil = $this->contenuAccueil();

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
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editProjetSoin', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getEditPartenaires(): void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
        $contenuAccueil = $this->contenuAccueil();

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
        $view = new \App\View\View();
        $post = $postTable->findPartenaires($id);
        $form = new \App\Service\BootstrapForm($post);

        $view->renderAdmin(['template' => 'editPartenaires', 'data' => ['contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function getAddActivite(): void
    {
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
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
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'addActivite', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }

    public function getAddProfessionnel(): void
    {
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
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
        $dataActivite = $this->allActivites();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'addProfessionnel', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'activites' => $dataActivite,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }

    public function getEditActivite(): void
    {
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
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
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editActivite', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function getEditProfessionnel(): void
    {
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
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

        $dataActivite = $this->allActivites();
        $post = $postTable->findPro($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editProfessionnel', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'activites' => $dataActivite, 'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function getProfil(): void
    {
        $countMessage = $this->countMessages();
        $countProfessionnel = $this->countProfessionnels();
        $countActivites = $this->countActivites();
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
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'profil', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'form' => $form,'errors' => $errors, 'error' => $error,'result'=>$result]]);
    }

    // Méthodes réutilisables

    public function countActivites()
    {
        return $this->database->getDb()->query("SELECT count(*) as nb FROM activites", 'App\Models\BackManager');
    }

    public function countProfessionnels()
    {
        return $this->database->getDb()->query("SELECT count(*) as nb FROM professionnels", 'App\Models\BackManager');
    }

    public function countMessages()
    {
        return $this->database->getDb()->query("SELECT count(*) as nb FROM messages", 'App\Models\BackManager');
    }

    public function lastActivite()
    {
        return $this->database->getDb()->query("SELECT * FROM activites ORDER BY id DESC LIMIT 0,1", 'App\Models\BackManager');
    }

    public function lastProfessionnel()
    {
        return $this->database->getDb()->query("SELECT * FROM activites LEFT JOIN professionnels ON activites.id = professionnels.id_activites WHERE id_activites IS NOT NULL ORDER BY professionnels.id DESC LIMIT 0,1", 'App\Models\BackManager');
    }

    public function lastMessage()
    {
        return $this->database->getDb()->query("SELECT * FROM messages ORDER BY id DESC LIMIT 0,1", 'App\Models\BackManager');
    }

    public function contenuAccueil()
    {
        return $this->database->getDb()->query("SELECT * FROM accueil", 'App\Models\BackManager');
    }

    public function contenuPresentation()
    {
        return $this->database->getDb()->query("SELECT * FROM presentation", 'App\Models\BackManager');
    }

    public function contenuProjetSoin()
    {
        return $this->database->getDb()->query("SELECT * FROM projetSoin", 'App\Models\BackManager');
    }

    public function contenuPartenaires()
    {
        return $this->database->getDb()->query("SELECT * FROM partenaires", 'App\Models\BackManager');
    }

    public function allActivites()
    {
        return $this->database->getDb()->query("SELECT * FROM activites ORDER BY id DESC", 'App\Models\BackManager');
    }

    public function allMessages()
    {
        return $this->database->getDb()->query("SELECT * FROM messages ORDER BY id DESC", 'App\Models\BackManager');
    }

    public function allProfessionnels()
    {
        return $this->database->getDb()->query("SELECT * FROM activites LEFT JOIN professionnels ON activites.id = professionnels.id_activites WHERE id_activites IS NOT NULL", 'App\Models\BackManager');
    }

    public function showMessage($getId)
    {
        return $this->database->getDb()->query("SELECT * FROM messages WHERE id = $getId", 'App\Models\BackManager');
    }

    public function updateProfil(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE users SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updateAccueil(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE accueil SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updatePresentation(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE presentation SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updatePartenaires(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE partenaires SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updateProjetSoin(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE projetSoin SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updateActivite(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE activites SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updateProfessionnel(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE professionnels SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function createActivite(array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("INSERT INTO activites SET $sqlPart", $attributes, true);
    }

    public function createProfessionnel(array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("INSERT INTO professionnels SET $sqlPart", $attributes, true);
    }

    public function deleteActivite(string $id):bool
    {
        return $this->query("DELETE FROM activites WHERE id = ?", [$id], true);
    }

    public function deleteMessage(string $id):bool
    {
        return $this->query("DELETE FROM messages WHERE id = ?", [$id], true);
    }

    public function deleteProfessionnel(string $id):bool
    {
        return $this->query("DELETE FROM professionnels WHERE id = ?", [$id], true);
    }

    public function find(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM activites  WHERE id = ?", [$id], null, true);
    }

    public function findPro(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM professionnels  WHERE id = ?", [$id], null, true);
    }

    public function findAccueil(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM accueil  WHERE id = ?", [$id], null, true);
    }

    public function findPresentation(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM presentation  WHERE id = ?", [$id], null, true);
    }

    public function findPartenaires(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM partenaires  WHERE id = ?", [$id], null, true);
    }

    public function findProjetSoin(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM projetSoin  WHERE id = ?", [$id], null, true);
    }

    public function query($statement, array $attributes = null, bool $one = false):bool
    {
        if ($attributes) {
            return $this->database->getDb()->prepare($statement, $attributes, str_replace('Table', 'Entity', get_class($this)), $one);
        }

        return $this->database->getDb()->query(
            $statement,
            str_replace('Table', 'Entity', get_class($this)),
            $one
        );
    }
}
