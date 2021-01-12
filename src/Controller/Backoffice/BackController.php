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
    private Request $request;

    public function __construct(FrontManager $postManager, BackManager $backManager, View $view, Database $database, Request $request)
    {
        $this->postManager = $postManager;
        $this->view = $view;
        $this->backManager = $backManager;
        $this->database = $database;
        $this->request = $request;

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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $this->request->getSession()->set('token', $token);
        
        $table = $this->database->getInstance()->getTable('GlobalManager');
        
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();

        $page = $this->request->getGet()->get('page');
        $episodesParPage = 6;
        $episodesTotalReq = $table->countActivites();
        $episodesTotal = $episodesTotalReq[0]['nb'];
        $pagesTotales = ceil($episodesTotal/$episodesParPage);
        if (isset($page) and !empty($page) and $page > 0 and $page <= $pagesTotales) {
            $page = intval($page);
            $pageCourante = $page;
        } else {
            $pageCourante = 1;
        }

        $depart = ($pageCourante - 1)*$episodesParPage;
        $dataActivite = $table->paginationActivites($depart, $episodesParPage);
        
        $this->view->renderAdmin(['template' => 'activitesManager', 'data' => ['pageCourante' => $pageCourante, 'pagesTotales' => $pagesTotales, 'token' => $token,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'activites' => $dataActivite]]);
    }

    public function professionnelsManager(): void
    {
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $this->request->getSession()->set('token', $token);
        
        $table = $this->database->getInstance()->getTable('GlobalManager');
        
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();

        $page = $this->request->getGet()->get('page');
        $episodesParPage = 6;
        $episodesTotalReq = $table->countProfessionnels();
        $episodesTotal = $episodesTotalReq[0]['nb'];
        $pagesTotales = ceil($episodesTotal/$episodesParPage);
        if (isset($page) and !empty($page) and $page > 0 and $page <= $pagesTotales) {
            $page = intval($page);
            $pageCourante = $page;
        } else {
            $pageCourante = 1;
        }

        $depart = ($pageCourante - 1)*$episodesParPage;
        $dataProfessionnels = $table->paginationProfessionnels($depart, $episodesParPage);

        $this->view->renderAdmin(['template' => 'professionnelsManager', 'data' => ['pageCourante' => $pageCourante, 'pagesTotales' => $pagesTotales,'token' => $token,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'professionnels' => $dataProfessionnels]]);
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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $this->request->getSession()->set('token', $token);
        
        $table = $this->database->getInstance()->getTable('GlobalManager');
        
        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $userId = $auth->getUserId();

        $page = $this->request->getGet()->get('page');
        $episodesParPage = 6;
        $episodesTotalReq = $table->countMessages();
        $episodesTotal = $episodesTotalReq[0]['nb'];
        $pagesTotales = ceil($episodesTotal/$episodesParPage);
        if (isset($page) and !empty($page) and $page > 0 and $page <= $pagesTotales) {
            $page = intval($page);
            $pageCourante = $page;
        } else {
            $pageCourante = 1;
        }

        $depart = ($pageCourante - 1)*$episodesParPage;
        $dataMessages = $table->paginationMessages($depart, $episodesParPage);
      
        $this->view->renderAdmin(['template' => 'messagesManager', 'data' => ['pageCourante' => $pageCourante, 'pagesTotales' => $pagesTotales,'token' => $token,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'userId' => $userId,'messages' => $dataMessages]]);
    }

    public function showMessage(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        
        $id = $this->request->getGet()->get('id');

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

        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
    
        $contenu = $this->request->getPost()->getWithoutHtml('contenu');
        $id = $this->request->getGet()->get('id');
        
        $tokenError = false;
        $error = false;
        $result = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (!empty($contenu)) {
                    $this->backManager->updateAccueil([
                    
                        'contenu' => $contenu,

                    ]);
                    $result = true;
                } else {
                    $error = true;
                }
            } else {
                $tokenError =true;
            }
        }

        $this->request->getSession()->set('token', $token);

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

        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
    
        $contenu = $this->request->getPost()->getWithoutHtml('contenu');
        $id = $this->request->getGet()->get('id');
        
        $error = false;
        $result = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (!empty($contenu)) {
                    $this->backManager->updatePresentation([
                    
                        'contenu' => $contenu,

                    ]);
                    $result = true;
                } else {
                    $error = true;
                }
            } else {
                $tokenError =true;
            }
        }

        $this->request->getSession()->set('token', $token);

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

        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
    
        $contenu = $this->request->getPost()->getWithoutHtml('contenu');
        $id = $this->request->getGet()->get('id');
        
        $error = false;
        $result = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (!empty($contenu)) {
                    $this->backManager->updateProjetSoin([
                    
                        'contenu' => $contenu,

                    ]);
                    $result = true;
                } else {
                    $error = true;
                }
            } else {
                $tokenError =true;
            }
        }
        
        $this->request->getSession()->set('token', $token);

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

        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
    
        $contenu = $this->request->getPost()->getWithoutHtml('contenu');
        $id = $this->request->getGet()->get('id');
        
        $error = false;
        $result = false;
        $tokenError = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (!empty($contenu)) {
                    $this->backManager->updatePartenaires([
                    
                        'contenu' => $contenu,

                    ]);
                    $result = true;
                } else {
                    $error = true;
                }
            } else {
                $tokenError =true;
            }
        }

        $post = $table->findPartenaires($id);
        $form = new \App\Service\BootstrapForm($post);

        $this->request->getSession()->set('token', $token);

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
        
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
        
        $nom = $this->request->getPost()->get('activite');
        $titre = $this->request->getPost()->get('titre');
        $description = $this->request->getPost()->getWithoutHtml('description');
        
        $error = false;
        $result = false;
        $tokenError = false;
        $photoError =false;
        $photoExtension = false;
        $photoTaille = false;
        $champs = false;
    
        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
                    $tailleMax = 2097152;
                    $extensionsValides = ['jpg','jpeg','gif','png'];
                    $extensionUpload = mb_strtolower(mb_substr(mb_strrchr($_FILES['photo']['name'], '.'), 1));
                    $nomPhoto = str_replace(" ", "", $nom);
                    $path = "images/" . $nomPhoto . "." . $extensionUpload ;

                    if (!($_FILES['photo']['size'] <= $tailleMax)) {
                        $photoTaille = true;
                    } elseif (!in_array($extensionUpload, $extensionsValides, true)) {
                        $photoExtension = true;
                    } elseif (empty($nom) || empty($titre) || empty($description)) {
                        $champs = true;
                    } else {
                        $res = move_uploaded_file($_FILES['photo']['tmp_name'], $path);
                        if ($res and !empty($nom) && !empty($titre) && !empty($description)) {
                            $resultat = $this->backManager->createActivite([
                                
                                'activite' => $nom,
                                'titre' => $titre,
                                'description' => $description,
                                'photo' => $nomPhoto . "." . $extensionUpload

                            ]);
                            $result = true;
                        } else {
                            $photoError = true;
                        }
                    }
                } elseif (!empty($nom) && !empty($titre) && !empty($description)) {
                    $this->backManager->createActivite([
                                
                        'activite' => $nom,
                        'titre' => $titre,
                        'description' => $description
                    
    
                    ]);
                    $result = true;
                } else {
                    $champs = true;
                }
            } else {
                $tokenError =true;
            }
        }

        $this->request->getSession()->set('token', $token);

        $form = new \App\Service\BootstrapForm($_POST);

        $this->view->renderAdmin(['template' => 'addActivite', 'data' => ['champs' => $champs,'photoExtension' => $photoExtension,'photoTaille' => $photoTaille,'photoError' => $photoError,'token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
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

        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
        
        $nom = $this->request->getPost()->get('nom');
        $activite = $this->request->getPost()->get('activite');
        
        $error = false;
        $result = false;
        $tokenError = false;
        $photoError =false;
        $photoExtension = false;
        $photoTaille = false;
        $champs = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
                    $tailleMax = 2097152;
                    $extensionsValides = ['jpg','jpeg','gif','png'];
                    $extensionUpload = mb_strtolower(mb_substr(mb_strrchr($_FILES['photo']['name'], '.'), 1));
                    $nomPhoto = str_replace(" ", "", $nom);
                    $path = "images/" . $nomPhoto . "." . $extensionUpload ;

                    if (!($_FILES['photo']['size'] <= $tailleMax)) {
                        $photoTaille = true;
                    } elseif (!in_array($extensionUpload, $extensionsValides, true)) {
                        $photoExtension = true;
                    } elseif (empty($nom) || empty($activite)) {
                        $champs = true;
                    } else {
                        $res = move_uploaded_file($_FILES['photo']['tmp_name'], $path);
                        if ($res and !empty($nom) && !empty($activite)) {
                            $resultat = $this->backManager->createProfessionnel([
                                
                                'nom' => $nom,
                                'id_activites' => $activite,
                                'photo' => $nomPhoto . "." . $extensionUpload

                            ]);
                            $result = true;
                        } else {
                            $photoError = true;
                        }
                    }
                } elseif (!empty($nom) && !empty($activite)) {
                    $this->backManager->createProfessionnel([
                        
                            'nom' => $nom,
                            'id_activites' => $activite,

                        ]);
                    $result = true;
                } else {
                    $error = true;
                }
            } else {
                $tokenError =true;
            }
        }

        $this->request->getSession()->set('token', $token);
        
        $form = new \App\Service\BootstrapForm($_POST);

        $this->view->renderAdmin(['template' => 'addProfessionnel', 'data' => ['champs' => $champs,'photoExtension' => $photoExtension,'photoTaille' => $photoTaille,'photoError' => $photoError,'token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'activites' => $dataActivite,'result' => $result, 'form' => $form, 'userId' => $userId,'error' => $error]]);
    }

    public function deleteActivite():void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');

        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
        $activiteId = $this->request->getGet()->get('id');
        
        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession and !empty($activiteId)) {
                $this->backManager->deleteActivite($activiteId);
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

        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
        $proId = $this->request->getGet()->get('id');

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession and !empty($proId)) {
                $this->backManager->deleteProfessionnel($proId);
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

        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
        $msgId = $this->request->getGet()->get('id');
        
        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession and !empty($msgId)) {
                $this->backManager->deleteMessage($msgId);
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

        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
        $userId = $this->request->getGet()->get('id');
        
        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession and !empty($userId)) {
                $this->backManager->deleteUser($userId);
                $this->deconnecter();
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
        
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');

        $nom = $this->request->getPost()->get('activite');
        $titre = $this->request->getPost()->get('titre');
        $description = $this->request->getPost()->getWithoutHtml('description');

        $id = $this->request->getGet()->get('id');
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
                    $extensionUpload = mb_strtolower(mb_substr(mb_strrchr($_FILES['photo']['name'], '.'), 1));
                    $nomPhoto = str_replace(" ", "", $nom);
                    $path = "images/" . $nomPhoto . "." . $extensionUpload ;

                    if (!($_FILES['photo']['size'] <= $tailleMax)) {
                        $photoTaille = true;
                    } elseif (!in_array($extensionUpload, $extensionsValides, true)) {
                        $photoExtension = true;
                    } else {
                        $res = move_uploaded_file($_FILES['photo']['tmp_name'], $path);
                        if ($res and !empty($nom) && !empty($titre) && !empty($description)) {
                            $resultat = $this->backManager->updateActivite($id, [
                            
                                'activite' => $nom,
                                'titre' => $titre,
                                'description' => $description,
                                'photo' => $nomPhoto . "." . $extensionUpload

                            ]);
                            $result = true;
                        } else {
                            $photoError = true;
                        }
                    }
                } elseif (!empty($nom) && !empty($titre) && !empty($description)) {
                    $resultat = $this->backManager->updateActivite($id, [
                                
                        'activite' => $nom,
                        'titre' => $titre,
                        'description' => $description,
    
                    ]);
                    $result = true;
                }
            } else {
                $tokenError =true;
            }
        } else {
            $error = true;
        }

        $this->request->getSession()->set('token', $token);

        $post = $table->find($id);
        $form = new \App\Service\BootstrapForm($post);

        $this->view->renderAdmin(['template' => 'editActivite', 'data' => ['activites' => $idActivites,'photoExtension' => $photoExtension,'photoTaille' => $photoTaille,'photoError' => $photoError,'token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function editProfessionnel(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');

        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');

        $nom = $this->request->getPost()->get('nom');
        $activite = $this->request->getPost()->get('activite');
        $id = $this->request->getGet()->get('id');
        $idActivite = $this->request->getGet()->get('id_activite');
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
        $photoError =false;
        $photoExtension = false;
        $photoTaille = false;

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
                    $tailleMax = 2097152;
                    $extensionsValides = ['jpg','jpeg','gif','png'];
                    $extensionUpload = mb_strtolower(mb_substr(mb_strrchr($_FILES['photo']['name'], '.'), 1));
                    $nomPhoto = str_replace(" ", "", $nom);
                    $path = "images/" . $nomPhoto . "." . $extensionUpload ;

                    if (!($_FILES['photo']['size'] <= $tailleMax)) {
                        $photoTaille = true;
                    } elseif (!in_array($extensionUpload, $extensionsValides, true)) {
                        $photoExtension = true;
                    } else {
                        $res = move_uploaded_file($_FILES['photo']['tmp_name'], $path);
                        if ($res and !empty($nom) && !empty($activite)) {
                            $resultat = $this->backManager->updateProfessionnel($id, [
                            
                                'nom' => $nom,
                                'id_activites' => $activite,
                                'photo' => $nomPhoto . "." . $extensionUpload

                            ]);
                            $result = true;
                        } else {
                            $photoError = true;
                        }
                    }
                } elseif (!empty($nom) && !empty($activite)) {
                    $resultat = $this->backManager->updateProfessionnel($id, [
                                
                        'nom' => $nom,
                        'id_activites' => $activite
    
                    ]);
                    $result = true;
                } else {
                    $error = true;
                }
            } else {
                $tokenError =true;
            }
        }

        $this->request->getSession()->set('token', $token);
        
        $post = $table->findPro($id);
        $form = new \App\Service\BootstrapForm($post);

        $this->view->renderAdmin(['template' => 'editProfessionnel', 'data' => ['photoExtension' => $photoExtension,'photoTaille' => $photoTaille,'photoError' => $photoError,'idProfessionnels' => $idProfessionnel,'token' => $token, 'tokenError' => $tokenError,'countM' => $countMessage,'countA' => $countActivites,'countP' => $countProfessionnel,'result' => $result,'activites' => $dataActivite, 'userId' => $userId,'error' => $error,'form' => $form]]);
    }

    public function profil(): void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');

        $countMessage = $table->countMessages();
        $countProfessionnel = $table->countProfessionnels();
        $countActivites = $table->countActivites();
        
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');
        
        $username = $this->request->getPost()->get('Username');
        $password = $this->request->getPost()->get('Password');
        $confirm = $this->request->getPost()->get('Confirm');
        $id = $this->request->getGet()->get('id');
        
        $idUser = $table->findUser($id);
        
        $errors = false;
        $error = false;
        $result = false;
        $tokenError = false;
        $regexError = false;
        $passError = false;

        if (!empty($_POST)) {
            if (!isset($tokenGet) && $tokenGet !== $tokenSession and !empty($id)) {
                $tokenError = true;
            } elseif (empty($username) && empty($password) && empty($confirm)) {
                $error=true;
            } elseif (!(mb_strlen($username) <= 20 && mb_strlen($username) >= 2)) {
                $regexError = true;
            } elseif (!preg_match("/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/", $password)) {
                $passError = true;
            } elseif ($password !== $confirm) {
                $errors = true;
            } else {
                $this->backManager->updateProfil($id, [
                                
                    'username' => $username,
                    'password' => password_hash($confirm, PASSWORD_DEFAULT)

                ]);
                $result = true;
            }
        }

        $this->request->getSession()->set('token', $token);

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
