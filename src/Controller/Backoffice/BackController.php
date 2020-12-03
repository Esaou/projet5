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

        $this->view->renderAdmin(['template' => 'index', 'data' => ['countM' => $countMessage,'userId' => $userId,'activites' => $dataActivite,'professionnels' => $dataProfessionnel,'messages' => $dataMessage,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function activitesManager(): void
    {
        $request = new Request();
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $request->getSession()->set('token', $token);
        
        $table = $this->database->getInstance()->getTable('GlobalManager');
        
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $dataActivite = $table->allActivites();
        
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();

        $this->view->renderAdmin(['template' => 'activitesManager', 'data' => ['token' => $token,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'activites' => $dataActivite]]);
    }

    public function professionnelsManager(): void
    {
        $request = new Request();
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $request->getSession()->set('token', $token);
        
        $table = $this->database->getInstance()->getTable('GlobalManager');
        
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $dataProfessionnels = $table->allProfessionnels();
        
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();

        $this->view->renderAdmin(['template' => 'professionnelsManager', 'data' => ['token' => $token,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'professionnels' => $dataProfessionnels]]);
    }

    public function pagesManager(): void
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
    
        $this->view->renderAdmin(['template' => 'pagesManager', 'data' => ['presentation' => $contenuPresentation,'projetSoins' => $contenuProjetSoin,'partenaires' => $contenuPartenaires,'contenus' => $contenuAccueil,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function messagesManager(): void
    {
        $request = new Request();
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $request->getSession()->set('token', $token);
        
        $table = $this->database->getInstance()->getTable('GlobalManager');
        
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $dataMessages = $table->allMessages();
        
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
      
        $this->view->renderAdmin(['template' => 'messagesManager', 'data' => ['token' => $token,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'messages' => $dataMessages]]);
    }

    public function showMessage(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        
        $request = new Request();
        $id = $request->getGet()->get('id');

        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $dataMessages = $table->showMessage($id);
        
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();

        $this->view->renderAdmin(['template' => 'showMessage', 'data' => ['countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'messages' => $dataMessages]]);
    }

    public function editAccueil(): void
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
                    $res = $this->backManager->updateAccueil([
                    
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

        $this->view->renderAdmin(['template' => 'editAccueil', 'data' => ['token' => $token, 'tokenError' => $tokenError,'contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function editPresentation(): void
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
                    $res = $this->backManager->updatePresentation([
                    
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

        $this->view->renderAdmin(['template' => 'editPresentation', 'data' => ['token' => $token, 'tokenError' => $tokenError,'contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function editProjetSoin(): void
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
                    $res = $this->backManager->updateProjetSoin([
                    
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

        $this->view->renderAdmin(['template' => 'editProjetSoin', 'data' => ['token' => $token, 'tokenError' => $tokenError,'contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function editPartenaires(): void
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
                    $res = $this->backManager->updatePartenaires([
                    
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

        $post = $table->findPartenaires($id);
        $form = new \App\Service\BootstrapForm($post);

        $request->getSession()->set('token', $token);

        $this->view->renderAdmin(['template' => 'editPartenaires', 'data' => ['token' => $token, 'tokenError' => $tokenError,'contenus' => $contenuAccueil,'form' => $form, 'error' => $error,'result' => $result,'countM' => $countMessage,'userId' => $userId,'countA' => $countActivites,'countP' => $countProfessionnel]]);
    }

    public function addActivite(): void
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
                                    $resultat = $this->backManager->createActivite([
                                    
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
                        $resultat = $this->backManager->createActivite([
                                    
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

        $this->view->renderAdmin(['template' => 'addActivite', 'data' => ['photoExtension' => $photoExtension,'photoTaille' => $photoTaille,'photoError' => $photoError,'token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }

    public function addProfessionnel(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');

        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $dataActivite = $table->allActivites();

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
                    $res = $this->backManager->createProfessionnel([
                        
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

        $this->view->renderAdmin(['template' => 'addProfessionnel', 'data' => ['token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'activites' => $dataActivite,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }

    public function deleteActivite():void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');

        $request = new Request();
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
        $activiteId = $request->getGet()->get('id');
        
        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                $result = $this->backManager->deleteActivite($activiteId);
                if ($result) {
                    header("Location: index?action=activitesManager");
                    exit();
                }
                header("Location: index?action=activitesManager");
                exit();
            }
            header("Location: index?action=activitesManager");
            exit();
        }
    }

    public function deleteProfessionnel():void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');

        $request = new Request();
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
        $proId = $request->getGet()->get('id');

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                $res = $this->backManager->deleteProfessionnel($proId);
                if ($res) {
                    header("Location: index?action=professionnelsManager");
                    exit();
                }
                header("Location: index?action=professionnelsManager");
                exit();
            }
            header("Location: index?action=professionnelsManager");
            exit();
        }
    }

    public function deleteMessage():void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');

        $request = new Request();
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
        $msgId = $request->getGet()->get('id');
        
        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                $res =  $this->backManager->deleteMessage($msgId);
                if ($res) {
                    header("Location: index?action=messagesManager");
                    exit();
                }
                header("Location: index?action=messagesManager");
                exit();
            }
            header("Location: index?action=messagesManager");
            exit();
        }
    }

    public function deleteUser():void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');

        $request = new Request();
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
        $userId = $request->getGet()->get('id');
        
        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                $res = $this->backManager->deleteUser($userId);
                if ($res) {
                    $this->deconnecter();
                } else {
                    header("Location: index?action=profil");
                    exit();
                }
            } else {
                header("Location: index?action=profil");
                exit();
            }
        }
    }

    public function editActivite(): void
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
                                $resultat = $this->backManager->updateActivite($id, [
                                
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
                    $resultat = $this->backManager->updateActivite($id, [
                                
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

        $this->view->renderAdmin(['template' => 'editActivite', 'data' => ['activites' => $idActivites,'photoExtension' => $photoExtension,'photoTaille' => $photoTaille,'photoError' => $photoError,'token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function editProfessionnel(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');

        $request = new Request();
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');

        $nom = $request->getPost()->get('nom');
        $activite = $request->getPost()->get('activite');
        $id = $request->getGet()->get('id');
        $idActivite = $request->getGet()->get('id_activite');
        $idProfessionnel = $table->idProfessionnel($id);

        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        $dataActivite = $table->allActivitesEditPro($idActivite);

        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();
        
        $error = false;
        $result = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (!empty($activite) && !empty($nom)) {
                    $res = $this->backManager->updateProfessionnel($id, [
                        
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
        
        $post = $table->findPro($id);
        $form = new \App\Service\BootstrapForm($post);

        $this->view->renderAdmin(['template' => 'editProfessionnel', 'data' => ['idProfessionnels' => $idProfessionnel,'token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'activites' => $dataActivite, 'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function profil(): void
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
        
        $idUser = $table->findUser($id);
        
        $errors = false;
        $error = false;
        $result = false;
        $tokenError = false;
        $regexError = false;
        $passError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (!empty($username) && !empty($password) && !empty($confirm)) {
                    if (mb_strlen($username) <= 20 && mb_strlen($username) >= 2) {
                        if (preg_match("/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/", $password)) {
                            if ($password === $confirm) {
                                $this->backManager->updateProfil($id, [
                                
                                    'username' => $username,
                                    'password' => password_hash($confirm, PASSWORD_DEFAULT)

                                ]);
                                $result = true;
                            } else {
                                $errors = true;
                            }
                        } else {
                            $passError = true;
                        }
                    } else {
                        $regexError = true;
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

        $this->view->renderAdmin(['template' => 'profil', 'data' => ['users' => $idUser,'passError' => $passError,'regexError' => $regexError,'token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'form' => $form,'errors' => $errors, 'error' => $error,'result'=>$result]]);
    }

    public function deconnecter():void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $auth->disconnect();
        header("Location: index?action=index");
        exit();
    }
}
