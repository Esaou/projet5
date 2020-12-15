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
    private Request $request;

    public function __construct(FrontManager $frontManager, View $view, Database $database, Request $request)
    {
        $this->frontManager = $frontManager;
        $this->database = $database;
        $this->view = $view;
        $this->request = $request;
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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $this->request->getSession()->get('token');
        $tokenGet = $this->request->getPost()->get('token');

        $nom = $this->request->getPost()->get('nom');
        $email = $this->request->getPost()->get('email');
        $objet = $this->request->getPost()->get('objet');
        $message = $this->request->getPost()->get('message');

        $error = false;
        $errors=false;
        $result = false;
        $nameError = false;
        $tokenError = false;
        $emailError = false;
        
        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (!preg_match("/^(?:[^\d\W][\-\s]{0,1}){2,40}$/i", $nom)) {
                    $nameError = true;
                } elseif (!preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $email)) {
                    $emailError = true;
                } elseif ((empty($nom) || empty($email) || empty($objet) || empty($message))) {
                    $errors = true;
                } elseif (!(mb_strlen($nom) < 40)) {
                    $error = true;
                } elseif (!empty($nom) and !empty($email) and !empty($objet) and !empty($message)) {
                    $pseudo = htmlspecialchars($nom);
                    $email = htmlspecialchars($email);
                    $objet = htmlspecialchars($objet);
                    $message = htmlspecialchars($message);
                    $this->frontManager->createMessage([
                                
                        'nom' => $pseudo,
                        'email' => $email,
                        'objet' => $objet,
                        'message' => $message
                        
            
                    ]);
                    $result = true;
                }
            } else {
                $tokenError = true;
            }
        }

        $this->request->getSession()->set('token', $token);

        $dataActivites = $this->frontManager->activites();
        $dataForm = $this->frontManager->form();

        $this->view->render(['template' => 'rejoindre', 'data' => ['emailError' => $emailError,'tokenSession' => $tokenSession, 'token' => $token, 'tokenError' => $tokenError,'nameError' => $nameError,'result' => $result, 'error' => $error,'errors' => $errors,'forms' => $dataForm, 'activites' => $dataActivites]]);
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
