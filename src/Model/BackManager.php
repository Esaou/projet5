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

        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
        
        $username = $request->getPost()->get('Username');
        $password = $request->getPost()->get('Password');
        $confirm = $request->getPost()->get('Confirm');
        $id = $request->getGet()->get('id');
        
        $users = $this->database->getDb()->query("SELECT * FROM users ORDER BY id DESC", 'App\Models\BackOffice');
        
        $errors = false;
        $error = false;
        $result = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
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
            } else {
                $tokenError = true;
            }
        }
        $request->getSession()->set('token', $token);
        $form = new \App\Service\BootstrapForm();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'profil', 'data' => ['token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'form' => $form,'errors' => $errors, 'error' => $error,'result'=>$result]]);
    }

    public function getActivitesManager(): void
    {
        $request = new Request();
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $request->getSession()->set('token', $token);
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataActivite = $table->allActivites();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'activitesManager', 'data' => ['token' => $token,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'activites' => $dataActivite]]);
    }

    public function getProfessionnelsManager(): void
    {
        $request = new Request();
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $request->getSession()->set('token', $token);
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataProfessionnels = $table->allProfessionnels();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'professionnelsManager', 'data' => ['token' => $token,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'professionnels' => $dataProfessionnels]]);
    }

    public function getMessagesManager(): void
    {
        $request = new Request();
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $request->getSession()->set('token', $token);
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        $dataMessages = $table->allMessages();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'messagesManager', 'data' => ['token' => $token,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'messages' => $dataMessages]]);
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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $tokenError = false;
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
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
            } else {
                $tokenError =true;
            }
        }
        $request->getSession()->set('token', $token);
        $post = $table->findAccueil($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editAccueil', 'data' => ['token' => $token, 'tokenError' => $tokenError,'contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
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
            } else {
                $tokenError =true;
            }
        }
        $request->getSession()->set('token', $token);
        $post = $table->findPresentation($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editPresentation', 'data' => ['token' => $token, 'tokenError' => $tokenError,'contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
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
            } else {
                $tokenError =true;
            }
        }
        $request->getSession()->set('token', $token);
        $post = $table->findProjetSoin($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editProjetSoin', 'data' => ['token' => $token, 'tokenError' => $tokenError,'contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
    
        $contenu = $request->getPost()->getWithoutHtml('contenu');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
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
            } else {
                $tokenError =true;
            }
        }
        $view = new \App\View\View();
        $post = $table->findPartenaires($id);
        $form = new \App\Service\BootstrapForm($post);
        $request->getSession()->set('token', $token);
        $view->renderAdmin(['template' => 'editPartenaires', 'data' => ['token' => $token, 'tokenError' => $tokenError,'contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');

        $nom = $request->getPost()->get('activite');
        $titre = $request->getPost()->get('titre');
        $description = $request->getPost()->getWithoutHtml('description');
        $id = $request->getGet()->get('id');
        $idActivites = $table->idActivite($id);
        
        $error = false;
        $result = false;
        $tokenError = false;
        $photoError =false;
        $photoExtension = false;
        $photoTaille = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
                    $tailleMax = 2097152;
                    $extensionsValides = ['jpg','jpeg','gif','png'];
                    if ($_FILES['photo']['size'] <= $tailleMax) {
                        $extensionUpload = mb_strtolower(mb_substr(mb_strrchr($_FILES['photo']['name'], '.'), 1));
                        if (in_array($extensionUpload, $extensionsValides, true)) {
                            $path = "images/" . $nom . "." . $extensionUpload ;
                            $res = move_uploaded_file($_FILES['photo']['tmp_name'], $path);
                            if ($res) {
                                $resultat = $table->updateActivite($id, [
                                
                                    'activite' => $nom,
                                    'titre' => $titre,
                                    'description' => $description,
                                    'photo' => $nom . "." . $extensionUpload
        
                                ]);
                                if ($resultat) {
                                    $result = true;
                                }
                            } else {
                                $photoError = true;
                            }
                        } else {
                            $photoExtension = true;
                        }
                    } else {
                        $photoTaille = true;
                    }
                } else {
                    $resultat = $table->updateActivite($id, [
                                
                        'activite' => $nom,
                        'titre' => $titre,
                        'description' => $description,
    
                    ]);
                    if ($resultat) {
                        $result = true;
                    }
                }
            } else {
                $tokenError =true;
            }
        } else {
            $error = true;
        }
        $request->getSession()->set('token', $token);
        $post = $table->find($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editActivite', 'data' => ['activites' => $idActivites,'photoExtension' => $photoExtension,'photoTaille' => $photoTaille,'photoError' => $photoError,'token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'userId' => $userId,'error' => $error,'form' => $form]]);
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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');

        $nom = $request->getPost()->get('nom');
        $activite = $request->getPost()->get('activite');
        $id = $request->getGet()->get('id');
        
        $error = false;
        $result = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
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
            } else {
                $tokenError =true;
            }
        }
        $request->getSession()->set('token', $token);
        $dataActivite = $table->allActivites();
        $post = $table->findPro($id);
        $form = new \App\Service\BootstrapForm($post);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'editProfessionnel', 'data' => ['token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'activites' => $dataActivite, 'userId' => $userId,'error' => $error,'form' => $form]]);
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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
        
        $nom = $request->getPost()->get('activite');
        $titre = $request->getPost()->get('titre');
        $description = $request->getPost()->getWithoutHtml('description');
        
        $error = false;
        $result = false;
        $tokenError = false;
        $photoError =false;
        $photoExtension = false;
        $photoTaille = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (!empty($nom) && !empty($titre)) {
                    if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
                        $tailleMax = 2097152;
                        $extensionsValides = ['jpg','jpeg','gif','png'];
                        if ($_FILES['photo']['size'] <= $tailleMax) {
                            $extensionUpload = mb_strtolower(mb_substr(mb_strrchr($_FILES['photo']['name'], '.'), 1));
                            if (in_array($extensionUpload, $extensionsValides, true)) {
                                $path = "images/" . $nom . "." . $extensionUpload ;
                                $res = move_uploaded_file($_FILES['photo']['tmp_name'], $path);
                                if ($res) {
                                    $resultat = $table->createActivite([
                                    
                                        'activite' => $nom,
                                        'titre' => $titre,
                                        'description' => $description,
                                        'photo' => $nom . "." . $extensionUpload
            
                                    ]);
                                    if ($resultat) {
                                        $result = true;
                                    }
                                } else {
                                    $photoError = true;
                                }
                            } else {
                                $photoExtension = true;
                            }
                        } else {
                            $photoTaille = true;
                        }
                    } else {
                        $resultat = $table->createActivite([
                                    
                            'activite' => $nom,
                            'titre' => $titre,
                            'description' => $description,
                            'photo' => ''
        
                        ]);
                        if ($resultat) {
                            $result = true;
                        }
                    }
                } else {
                    $error = true;
                }
            } else {
                $tokenError =true;
            }
        }
        
        $request->getSession()->set('token', $token);
        $form = new \App\Service\BootstrapForm($_POST);
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'addActivite', 'data' => ['photoExtension' => $photoExtension,'photoTaille' => $photoTaille,'photoError' => $photoError,'token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
        
        $nom = $request->getPost()->get('nom');
        $activite = $request->getPost()->get('activite');
        
        $error = false;
        $result = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
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
            } else {
                $tokenError =true;
            }
        }
        $request->getSession()->set('token', $token);
        $form = new \App\Service\BootstrapForm($_POST);
        $dataActivite = $table->allActivites();
        $view = new \App\View\View();
        $view->renderAdmin(['template' => 'addProfessionnel', 'data' => ['token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'activites' => $dataActivite,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }
}
