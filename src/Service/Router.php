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
use App\View\View;

class Router
{
    private Database $database;
    private View $view;
    private array $get;

    public function __construct()
    {
        // dépendance
        $this->database = new Database('dbs1060027', 'dbu86760', 'JaaH7Lzj.', 'db5001239317.hosting-data.io');
        $this->view = new View();

        // En attendent de mettre en place la class App\Service\Http\Request
        $this->get = $_GET;
    }

    public function run(): void
    {
        $action = $this->get['action'] ?? 'index';

        if ($action === 'index') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database);
            $controller->index();
        } elseif ($action === 'presentation') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database);
            $controller->presentation();
        } elseif ($action === 'projetSoin') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database);
            $controller->projetSoin();
        } elseif ($action === 'partenaires') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database);
            $controller->partenaires();
        } elseif ($action === 'activites') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database);
            $controller->activites();
        } elseif ($action === 'rejoindre') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database);
            $controller->rejoindre();
        } elseif ($action === 'contact') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database);
            $controller->contact();
        } elseif ($action === 'login') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new UsersController($usersManager, $postManager, $this->view, $this->database);
            $controller->login();
        } elseif ($action === 'indexAdmin') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->index();
        } elseif ($action === 'activitesManager') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->activitesManager();
        } elseif ($action === 'professionnelsManager') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->professionnelsManager();
        } elseif ($action === 'messagesManager') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->messagesManager();
        } elseif ($action === 'pagesManager') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->pagesManager();
        } elseif ($action === 'showMessage') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->showMessage();
        } elseif ($action === 'deleteActivite') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->deleteActivite();
        } elseif ($action === 'deleteProfessionnel') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->deleteProfessionnel();
        } elseif ($action === 'deleteMessage') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->deleteMessage();
        } elseif ($action === 'addActivite') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->addActivite();
        } elseif ($action === 'addProfessionnel') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->addProfessionnel();
        } elseif ($action === 'editActivite') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->editActivite();
        } elseif ($action === 'editProfessionnel') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->editProfessionnel();
        } elseif ($action === 'deconnecter') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $backManager = new BackManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->deconnecter();
        } elseif ($action === 'profil') {
            $postManager = new FrontManager($this->database);
            $backManager = new BackManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->profil();
        } elseif ($action === 'editAccueil') {
            $postManager = new FrontManager($this->database);
            $backManager = new BackManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->editAccueil();
        } elseif ($action === 'editPartenaires') {
            $postManager = new FrontManager($this->database);
            $backManager = new BackManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->editPartenaires();
        } elseif ($action === 'editPresentation') {
            $postManager = new FrontManager($this->database);
            $backManager = new BackManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->editPresentation();
        } elseif ($action === 'editProjetSoin') {
            $postManager = new FrontManager($this->database);
            $backManager = new BackManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $backManager, $this->view, $this->database);
            $controller->editProjetSoin();
        } elseif ($action === 'forbidden') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database);
            $controller->forbidden();
        } else {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view, $this->database);
            $controller->notFound();
        }
    }
}
