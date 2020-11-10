<?php

declare(strict_types=1);

namespace  App\Service;

use App\Controller\Backoffice\BackController;
use App\Controller\Frontoffice\FrontController;
use App\Controller\Frontoffice\UsersController;
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
        $this->database = new Database('etoile', 'root', '', 'localhost');
        $this->view = new View();

        // En attendent de mettre en place la class App\Service\Http\Request
        $this->get = $_GET;
    }

    public function run(): void
    {
        $action = $this->get['action'] ?? 'index';

        if ($action === 'index') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view);
            $controller->index();
        } elseif ($action === 'presentation') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view);
            $controller->presentation();
        } elseif ($action === 'projetSoin') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view);
            $controller->projetSoin();
        } elseif ($action === 'partenaires') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view);
            $controller->partenaires();
        } elseif ($action === 'activites') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view);
            $controller->activites();
        } elseif ($action === 'rejoindre') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view);
            $controller->rejoindre();
        } elseif ($action === 'contact') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view);
            $controller->contact();
        } elseif ($action === 'login') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new UsersController($usersManager, $postManager, $this->view, $this->database);
            $controller->login();
        } elseif ($action === 'indexAdmin') {
            $postManager = new FrontManager($this->database);
            $usersManager = new UsersManager($this->database);
            $controller = new BackController($postManager, $this->view, $this->database);
            $controller->index();
        } elseif ($action === 'forbidden') {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view);
            $controller->forbidden();
        } else {
            $postManager = new FrontManager($this->database);
            $controller = new FrontController($postManager, $this->view);
            $controller->notFound();
        }
    }
}
