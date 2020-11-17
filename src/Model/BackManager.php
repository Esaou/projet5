<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;
use App\Service\Http\Request;

class BackManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

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
        return $this->database->getDb()->query("SELECT * FROM accueil", 'App\Models\BackManager');
    }

    public function contenuPresentation()
    {
        return $this->database->getDb()->query("SELECT * FROM presentation", 'App\Models\BackManager');
    }

    public function contenuProjetSoin()
    {
        return $this->database->getDb()->query("SELECT * FROM projetSoin", 'App\Models\BackManager');
    }

    public function contenuPartenaires()
    {
        return $this->database->getDb()->query("SELECT * FROM partenaires", 'App\Models\BackManager');
    }

    public function allActivites()
    {
        return $this->database->getDb()->query("SELECT * FROM activites ORDER BY id DESC", 'App\Models\BackManager');
    }

    public function allMessages()
    {
        return $this->database->getDb()->query("SELECT * FROM messages ORDER BY id DESC", 'App\Models\BackManager');
    }

    public function showMessage($getId)
    {
        return $this->database->getDb()->query("SELECT * FROM messages WHERE id = $getId", 'App\Models\BackManager');
    }

    public function allProfessionnels()
    {
        return $this->database->getDb()->query("SELECT * FROM activites LEFT JOIN professionnels ON activites.id = professionnels.id_activites WHERE id_activites IS NOT NULL", 'App\Models\BackManager');
    }

    public function updateProfil(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE users SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updateAccueil(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE accueil SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updatePresentation(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE presentation SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updatePartenaires(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE partenaires SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updateProjetSoin(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE projetSoin SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updateActivite(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE activites SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function updateProfessionnel(string $id, array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE professionnels SET $sqlPart WHERE id = $id", $attributes, true);
    }

    public function createActivite(array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("INSERT INTO activites SET $sqlPart", $attributes, true);
    }

    public function createProfessionnel(array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("INSERT INTO professionnels SET $sqlPart", $attributes, true);
    }

    public function deleteActivite(string $id):bool
    {
        return $this->query("DELETE FROM activites WHERE id = ?", [$id], true);
    }

    public function deleteMessage(string $id):bool
    {
        return $this->query("DELETE FROM messages WHERE id = ?", [$id], true);
    }

    public function deleteProfessionnel(string $id):bool
    {
        return $this->query("DELETE FROM professionnels WHERE id = ?", [$id], true);
    }

    public function query($statement, array $attributes = null, bool $one = false):bool
    {
        if ($attributes) {
            return $this->database->getDb()->prepare($statement, $attributes, str_replace('Table', 'Entity', get_class($this)), $one);
        }

        return $this->database->getDb()->query(
            $statement,
            str_replace('Table', 'Entity', get_class($this)),
            $one
        );
    }

    public function find(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM activites  WHERE id = ?", [$id], null, true);
    }

    public function findPro(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM professionnels  WHERE id = ?", [$id], null, true);
    }

    public function findAccueil(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM accueil  WHERE id = ?", [$id], null, true);
    }

    public function findPresentation(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM presentation  WHERE id = ?", [$id], null, true);
    }

    public function findPartenaires(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM partenaires  WHERE id = ?", [$id], null, true);
    }

    public function findProjetSoin(string $id):object
    {
        return $this->database->getDb()->prepare("SELECT * FROM projetSoin  WHERE id = ?", [$id], null, true);
    }
}
