<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Model\CommentManager;
use App\Model\FrontManager;
use App\Service\Database;
use App\Service\Http\Request;
use App\View\View;

class FrontController
{
    private FrontManager $frontManager;
    private View $view;
    private Database $database;

    public function __construct(FrontManager $frontManager, View $view, Database $database)
    {
        $this->frontManager = $frontManager;
        $this->database = $database;
        $this->view = $view;
    }

    public function index(): void
    {
        $dataEncadre = $this->frontManager->encadre();
        $dataActivites = $this->frontManager->activites();
        
        $this->view->render(['template' => 'index', 'data' => ['encadres' => $dataEncadre,'activites' => $dataActivites]]);
    }

    public function presentation(): void
    {
        $dataActivites = $this->frontManager->activites();
        $table = new \App\Model\GlobalManager($this->database);
        $contenu = $table->contenuPresentation();
        $this->view->render(['template' => 'presentation', 'data' => ['presentation' => $contenu,'activites' => $dataActivites]]);
    }

    public function projetSoin(): void
    {
        $dataActivites = $this->frontManager->activites();
        $table = new \App\Model\GlobalManager($this->database);
        $contenu = $table->contenuProjetSoin();
        $this->view->render(['template' => 'projetSoin', 'data' => ['projetSoins' => $contenu,'activites' => $dataActivites]]);
    }

    public function partenaires(): void
    {
        $dataActivites = $this->frontManager->activites();
        $table = new \App\Model\GlobalManager($this->database);
        $contenu = $table->contenuPartenaires();
        $this->view->render(['template' => 'partenaires', 'data' => ['partenaires' => $contenu,'activites' => $dataActivites]]);
    }

    public function activites(): void
    {
        $dataActivites = $this->frontManager->activites();
        $dataShowActivites = $this->frontManager->showActivites();
        $dataShowProfessionnels = $this->frontManager->showProfessionnels();
        $this->view->render(['template' => 'activites', 'data' => ['activites' => $dataActivites,'showActivites' => $dataShowActivites,'professionnels' => $dataShowProfessionnels]]);
    }

    public function rejoindre(): void
    {
        $this->frontManager->getRejoindre();
    }

    public function contact(): void
    {
        $dataActivites = $this->frontManager->activites();
        $this->view->render(['template' => 'contact', 'data' => ['activites' => $dataActivites]]);
    }

    public function notFound():void
    {
        $dataActivites = $this->frontManager->activites();
        $this->view->render(['template' => 'notFound', 'data' => ['activites' => $dataActivites]]);
    }

    public function forbidden():void
    {
        $dataActivites = $this->frontManager->activites();
        $this->view->render(['template' => 'forbidden', 'data' => ['activites' => $dataActivites]]);
    }
}
