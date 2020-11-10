<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Model\CommentManager;
use App\Model\FrontManager;
use App\View\View;

class FrontController
{
    private FrontManager $postManager;
    private View $view;

    public function __construct(FrontManager $postManager, View $view)
    {
        $this->postManager = $postManager;
        $this->view = $view;
    }

    public function index(): void
    {
        $dataEncadre = $this->postManager->encadre();
        $dataActivites = $this->postManager->activites();
        
        $this->view->render(['template' => 'index', 'data' => ['encadres' => $dataEncadre,'activites' => $dataActivites]]);
    }

    public function presentation(): void
    {
        $this->view->render(['template' => 'presentation', 'data' => []]);
    }

    public function projetSoin(): void
    {
        $this->view->render(['template' => 'projetSoin', 'data' => []]);
    }

    public function partenaires(): void
    {
        $this->view->render(['template' => 'partenaires', 'data' => []]);
    }

    public function activites(): void
    {
        $this->view->render(['template' => 'activites', 'data' => []]);
    }

    public function contact(): void
    {
        $this->view->render(['template' => 'contact', 'data' => []]);
    }

    public function rejoindre(): void
    {
        $dataForm = $this->postManager->form();
        $this->view->render(['template' => 'rejoindre', 'data' => ['forms' => $dataForm]]);
    }

    public function notFound():void
    {
        $this->view->render(['template' => 'notFound', 'data' => []]);
    }

    public function forbidden():void
    {
        $this->view->render(['template' => 'forbidden', 'data' => []]);
    }
}
