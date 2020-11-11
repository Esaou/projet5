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
    private FrontManager $postManager;
    private View $view;
    private Database $database;

    public function __construct(FrontManager $postManager, View $view, Database $database)
    {
        $this->postManager = $postManager;
        $this->database = $database;
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
        $dataActivites = $this->postManager->activites();
        $this->view->render(['template' => 'presentation', 'data' => ['activites' => $dataActivites]]);
    }

    public function projetSoin(): void
    {
        $dataActivites = $this->postManager->activites();
        $this->view->render(['template' => 'projetSoin', 'data' => ['activites' => $dataActivites]]);
    }

    public function partenaires(): void
    {
        $dataActivites = $this->postManager->activites();
        $this->view->render(['template' => 'partenaires', 'data' => ['activites' => $dataActivites]]);
    }

    public function activites(): void
    {
        $dataActivites = $this->postManager->activites();
        $dataShowActivites = $this->postManager->showActivites();
        $dataShowProfessionnels = $this->postManager->showProfessionnels();
        $this->view->render(['template' => 'activites', 'data' => ['activites' => $dataActivites,'showActivites' => $dataShowActivites,'professionnels' => $dataShowProfessionnels]]);
    }

    public function contact(): void
    {
        $dataActivites = $this->postManager->activites();
        $this->view->render(['template' => 'contact', 'data' => ['activites' => $dataActivites]]);
    }

    public function rejoindre(): void
    {
        $request = new Request();

        
        $error = false;
        $errors=false;
        $result = false;

        $nom = $request->getPost()->get('nom');
        $email = $request->getPost()->get('email');
        $objet = $request->getPost()->get('objet');
        $message = $request->getPost()->get('message');

        $postTable = $this->database->getInstance()->getTable('FrontManager');

        if (!empty($_POST)) {
            if ((isset($nom,$email,$objet,$message) and !empty($nom) and !empty($email) and !empty($objet) and !empty($message))) {
                $pseudo = htmlspecialchars($nom);
                $email = htmlspecialchars($email);
                $objet = htmlspecialchars($objet);
                $message = htmlspecialchars($message);

                if (mb_strlen($pseudo) < 25) {
                    $postTable->createMessage([
            
                        'nom' => $pseudo,
                        'email' => $email,
                        'objet' => $objet,
                        'message' => $message
                        
            
                    ]);
                    $result = true;
                } else {
                    $error = true;
                }
            } else {
                $errors= true;
            }
        }
        $dataForm = $this->postManager->form();
        $dataActivites = $this->postManager->activites();
        $this->view->render(['template' => 'rejoindre', 'data' => ['result' => $result, 'error' => $error,'errors' => $errors,'forms' => $dataForm, 'activites' => $dataActivites]]);
    }

    public function notFound():void
    {
        $dataActivites = $this->postManager->activites();
        $this->view->render(['template' => 'notFound', 'data' => ['activites' => $dataActivites]]);
    }

    public function forbidden():void
    {
        $dataActivites = $this->postManager->activites();
        $this->view->render(['template' => 'forbidden', 'data' => ['activites' => $dataActivites]]);
    }
}
