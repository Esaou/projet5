<?php

declare(strict_types=1);

namespace App\Controller\Backoffice;

use App\Model\CommentManager;

use App\Model\FrontManager;
use App\Service\Database;
use App\View\View;

class BackController
{
    private FrontManager $postManager;
    private Database $database;
    private View $view;

    public function __construct(FrontManager $postManager, View $view, Database $database)
    {
        $this->postManager = $postManager;
        $this->view = $view;
        $this->database = $database;

        $app = $this->database->getInstance();

        $auth = new \App\Service\Security\AccessControl($app->getDb());

        if (!$auth->logged()) {
            header('Location: index?action=forbidden');
        }
    }

    public function index(): void
    {
        $this->view->renderAdmin(['template' => 'index', 'data' => []]);
    }
}
