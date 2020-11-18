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
        $this->backManager->getIndex();
    }

    public function activitesManager(): void
    {
        $this->backManager->getActivitesManager();
    }

    public function professionnelsManager(): void
    {
        $this->backManager->getProfessionnelsManager();
    }

    public function pagesManager(): void
    {
        $this->backManager->getPagesManager();
    }

    public function messagesManager(): void
    {
        $this->backManager->getMessagesManager();
    }

    public function showMessage(): void
    {
        $this->backManager->getShowMessage();
    }

    public function editAccueil(): void
    {
        $this->backManager->getEditAccueil();
    }

    public function editPresentation(): void
    {
        $this->backManager->getEditPresentation();
    }

    public function editProjetSoin(): void
    {
        $this->backManager->getEditProjetSoin();
    }

    public function editPartenaires(): void
    {
        $this->backManager->getEditPartenaires();
    }

    public function addActivite(): void
    {
        $this->backManager->getAddActivite();
    }

    public function addProfessionnel(): void
    {
        $this->backManager->getAddProfessionnel();
    }

    public function deleteActivite():void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
        $activiteId = $request->getGet()->get('id');
        

        if (!empty($_POST)) {
            $result = $table->deleteActivite($activiteId);
            if ($result) {
                header("Location: index?action=activitesManager");
            } else {
                header("Location: index?action=activitesManager");
            }
        }
    }

    public function deleteProfessionnel():void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
        $proId = $request->getGet()->get('id');
        

        if (!empty($_POST)) {
            $res = $table->deleteProfessionnel($proId);
            if ($res) {
                header("Location: index?action=professionnelsManager");
            } else {
                header("Location: index?action=professionnelsManager");
            }
        }
    }

    public function deleteMessage():void
    {
        $table = $this->database->getInstance()->getTable('GlobalManager');
        $postTable = $this->database->getInstance()->getTable('BackManager');
        $request = new Request();
        $msgId = $request->getGet()->get('id');
        

        if (!empty($_POST)) {
            $res = $table->deleteMessage($msgId);
            if ($res) {
                header("Location: index?action=messagesManager");
            } else {
                header("Location: index?action=messagesManager");
            }
        }
    }

    public function editActivite(): void
    {
        $this->backManager->getEditActivite();
    }

    public function editProfessionnel(): void
    {
        $this->backManager->getEditProfessionnel();
    }

    public function profil(): void
    {
        $this->backManager->getProfil();
    }

    public function deconnecter():void
    {
        $app = $this->database->getInstance();
        $auth = new \App\Service\Security\AccessControl($app->getDb());
        $auth->disconnect();
        header("Location: index?action=index");
    }
}
