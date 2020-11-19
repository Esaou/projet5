<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;
use App\Service\Http\Request;

class FrontManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getRejoindre(): void
    {
        $request = new Request();

        
        $error = false;
        $errors=false;
        $result = false;
        $nameError = false;

        $nom = $request->getPost()->get('nom');
        $email = $request->getPost()->get('email');
        $objet = $request->getPost()->get('objet');
        $message = $request->getPost()->get('message');

        $postTable = $this->database->getInstance()->getTable('GlobalManager');

        if (!empty($_POST)) {
            if ((isset($nom,$email,$objet,$message) and !empty($nom) and !empty($email) and !empty($objet) and !empty($message))) {
                //if (preg_match("/\^[a-zA-Z]\$/", $nom)){
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
                //}else{
                   // $nameError = true;
                //}
            } else {
                $errors= true;
            }
        }
        $dataForm = $this->form();
        $dataActivites = $this->activites();
        $view = new \App\View\View();
        $view->render(['template' => 'rejoindre', 'data' => ['nameError' => $nameError,'result' => $result, 'error' => $error,'errors' => $errors,'forms' => $dataForm, 'activites' => $dataActivites]]);
    }

    public function encadre()
    {
        return $this->database->getDb()->query("SELECT * FROM accueil ORDER BY id DESC", 'App\Models\BackOffice');
    }

    public function activites()
    {
        return $this->database->getDb()->query("SELECT * FROM activites ORDER BY id", 'App\Models\FrontManager');
    }

    public function showActivites()
    {
        $request = new Request();
        $getId = $request->getGet()->get('id');
        return $this->database->getDb()->prepare('SELECT * FROM activites WHERE id = ?', [$getId], 'App\Models\FrontManager', true);
    }

    public function showProfessionnels()
    {
        $request = new Request();
        $getId = $request->getGet()->get('id');
        return $this->database->getDb()->query("SELECT * FROM professionnels WHERE id_activites = $getId", 'App\Models\FrontManager');
    }

    public function form()
    {
        return new \App\Service\BootstrapForm();
    }
}
