<?php

declare(strict_types=1);

namespace  App\Service;

use App\Controller\Backoffice\BackController;
use App\Controller\Frontoffice\FrontController;
use App\Controller\Frontoffice\UsersController;
use App\Model\BackManager;
use App\Model\CommentManager;
use App\Model\FrontManager;
use App\Model\UsersManager;
use App\Service\Database;
use App\Service\Http\Request;
use App\View\View;

class Router
{
    private Database $database;
    private View $view;
    private $request;

    public function __construct()
    {
        // dépendance
        $this->database = new Database('etoile', 'root', '', 'localhost');
        $this->view = new View();
        $this->request = new Request();
    }

    public function run(): void
    {
        $action = $this->request->getGet()->get('action');
        if (!$action) {
            $action = 'index';
        }

        if ($action === 'index') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database, $this->request);
            $controller->index();
        } elseif ($action === 'presentation') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database, $this->request);
            $controller->presentation();
        } elseif ($action === 'projetSoin') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database, $this->request);
            $controller->projetSoin();
        } elseif ($action === 'partenaires') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database, $this->request);
            $controller->partenaires();
        } elseif ($action === 'activites') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database, $this->request);
            $controller->activites();
        } elseif ($action === 'rejoindre') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database, $this->request);
            $controller->rejoindre();
        } elseif ($action === 'contact') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database, $this->request);
            $controller->contact();
        } elseif ($action === 'login') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new UsersController($usersManager, $postManager, $this->view, $this->database, $this->request);
            $controller->login();
        } elseif ($action === 'indexAdmin') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->index();
        } elseif ($action === 'activitesManager') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->activitesManager();
        } elseif ($action === 'professionnelsManager') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->professionnelsManager();
        } elseif ($action === 'messagesManager') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->messagesManager();
        } elseif ($action === 'pagesManager') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->pagesManager();
        } elseif ($action === 'showMessage') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->showMessage();
        } elseif ($action === 'deleteActivite') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->deleteActivite();
        } elseif ($action === 'deleteProfessionnel') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->deleteProfessionnel();
        } elseif ($action === 'deleteMessage') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->deleteMessage();
        } elseif ($action === 'deleteUser') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->deleteUser();
        } elseif ($action === 'addActivite') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->addActivite();
        } elseif ($action === 'addProfessionnel') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->addProfessionnel();
        } elseif ($action === 'editActivite') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->editActivite();
        } elseif ($action === 'editProfessionnel') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->editProfessionnel();
        } elseif ($action === 'deconnecter') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->deconnecter();
        } elseif ($action === 'profil') {
            $postManager = new FrontManager($this->database);
            $backManager = new BackManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->profil();
        } elseif ($action === 'editAccueil') {
            $postManager = new FrontManager($this->database);
            $backManager = new BackManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->editAccueil();
        } elseif ($action === 'editPartenaires') {
            $postManager = new FrontManager($this->database);
            $backManager = new BackManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->editPartenaires();
        } elseif ($action === 'editPresentation') {
            $postManager = new FrontManager($this->database);
            $backManager = new BackManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->editPresentation();
        } elseif ($action === 'editProjetSoin') {
            $postManager = new FrontManager($this->database);
            $backManager = new BackManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database, $this->request);
            $controller->editProjetSoin();
        } elseif ($action === 'forbidden') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database, $this->request);
            $controller->forbidden();
        } else {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database, $this->request);
            $controller->notFound();
        }
    }
}
