<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;
use App\Service\Http\Request;

class GlobalManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    // CONTENT

    public function countActivites()
    {
        return $this->database->getDb()->query("SELECT count(*) as nb FROM activites", 'App\Models\BackManager');
    }

    public function countProfessionnels()
    {
        return $this->database->getDb()->query("SELECT count(*) as nb FROM professionnels", 'App\Models\BackManager');
    }

    public function countMessages()
    {
        return $this->database->getDb()->query("SELECT count(*) as nb FROM messages", 'App\Models\BackManager');
    }

    public function allActivites()
    {
        return $this->database->getDb()->query("SELECT * FROM activites ORDER BY id DESC", 'App\Models\BackManager');
    }

    public function allActivitesEditPro($id)
    {
        return $this->database->getDb()->query("SELECT * FROM activites WHERE activites.id != $id", 'App\Models\BackManager');
    }

    public function allMessages()
    {
        return $this->database->getDb()->query("SELECT * FROM messages ORDER BY id DESC", 'App\Models\BackManager');
    }

    public function allProfessionnels()
    {
        return $this->database->getDb()->query("SELECT * FROM activites LEFT JOIN professionnels ON activites.id = professionnels.id_activites WHERE id_activites IS NOT NULL", 'App\Models\BackManager');
    }

    public function lastActivite()
    {
        return $this->database->getDb()->query("SELECT * FROM activites ORDER BY id DESC LIMIT 0,1", 'App\Models\BackManager');
    }

    public function lastProfessionnel()
    {
        return $this->database->getDb()->query("SELECT * FROM activites LEFT JOIN professionnels ON activites.id = professionnels.id_activites WHERE id_activites IS NOT NULL ORDER BY professionnels.id DESC LIMIT 0,1", 'App\Models\BackManager');
    }

    public function lastMessage()
    {
        return $this->database->getDb()->query("SELECT * FROM messages ORDER BY id DESC LIMIT 0,1", 'App\Models\BackManager');
    }

    public function contenuAccueil()
    {
        return $this->database->getDb()->query("SELECT * FROM pages  WHERE nom='accueil'", 'App\Models\BackManager');
    }

    public function contenuPresentation()
    {
        return $this->database->getDb()->query("SELECT * FROM pages  WHERE nom='presentation'", 'App\Models\BackManager');
    }

    public function contenuProjetSoin()
    {
        return $this->database->getDb()->query("SELECT * FROM pages  WHERE nom='projetSoin'", 'App\Models\BackManager');
    }

    public function contenuPartenaires()
    {
        return $this->database->getDb()->query("SELECT * FROM pages  WHERE nom='partenaires'", 'App\Models\BackManager');
    }

    public function showMessage($getId)
    {
        return $this->database->getDb()->query("SELECT * FROM messages WHERE id = $getId", 'App\Models\BackManager');
    }

    public function idActivite($getId)
    {
        return $this->database->getDb()->query("SELECT * FROM activites WHERE id = $getId", 'App\Models\BackManager');
    }

    public function idProfessionnel($id)
    {
        return $this->database->getDb()->query("SELECT * FROM professionnels LEFT JOIN activites ON activites.id = professionnels.id_activites WHERE professionnels.id=$id", 'App\Models\BackManager');
    }

    // FIND

    public function find(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM activites  WHERE id = ?", [$id], null, true);
    }

    public function findUser(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM users  WHERE id = ?", [$id], null, true);
    }

    public function findPro(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM professionnels  WHERE id = ?", [$id], null, true);
    }

    public function findAccueil(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM pages  WHERE nom = 'accueil'", [$id], null, true);
    }

    public function findPresentation(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM pages  WHERE nom='presentation'", [$id], null, true);
    }

    public function findPartenaires(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM pages  WHERE nom='partenaires'", [$id], null, true);
    }

    public function findProjetSoin(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM pages  WHERE nom='projetSoin'", [$id], null, true);
    }
}
