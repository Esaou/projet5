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
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $tokenSession = $request->getSession()->get('token');
        $tokenGet = $request->getPost()->get('token');
        
        $error = false;
        $errors=false;
        $result = false;
        $nameError = false;
        $tokenError = false;
        $emailError = false;

        $nom = $request->getPost()->get('nom');
        $email = $request->getPost()->get('email');
        $objet = $request->getPost()->get('objet');
        $message = $request->getPost()->get('message');

        $postTable = $this->database->getInstance()->getTable('GlobalManager');

        if (!empty($_POST)) {
            if (isset($tokenGet) && $tokenGet === $tokenSession) {
                if (preg_match("/^(?:[^\d\W][\-\s]{0,1}){2,40}$/i", $nom)) {
                    if (preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $email)) {
                        if ((isset($nom,$email,$objet,$message) and !empty($nom) and !empty($email) and !empty($objet) and !empty($message))) {
                            $pseudo = htmlspecialchars($nom);
                            $email = htmlspecialchars($email);
                            $objet = htmlspecialchars($objet);
                            $message = htmlspecialchars($message);

                            if (mb_strlen($pseudo) < 40) {
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
                    } else {
                        $emailError = true;
                    }
                } else {
                    $nameError = true;
                }
            } else {
                $tokenError = true;
            }
        }
        
        $request->getSession()->set('token', $token);

        $dataForm = $this->form();
        $dataActivites = $this->activites();
        $view = new \App\View\View();
        $view->render(['template' => 'rejoindre', 'data' => ['emailError' => $emailError,'tokenSession' => $tokenSession, 'token' => $token, 'tokenError' => $tokenError,'nameError' => $nameError,'result' => $result, 'error' => $error,'errors' => $errors,'forms' => $dataForm, 'activites' => $dataActivites]]);
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
