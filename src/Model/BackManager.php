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

    // CREATE

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

    // UPDATE

    public function updateAccueil(array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE pages SET $sqlPart WHERE nom = 'accueil'", $attributes, true);
    }

    public function updatePresentation(array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE pages SET $sqlPart WHERE nom = 'presentation'", $attributes, true);
    }

    public function updatePartenaires(array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE pages SET $sqlPart WHERE nom = 'partenaires'", $attributes, true);
    }

    public function updateProjetSoin(array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE pages SET $sqlPart WHERE nom = 'projetSoin'", $attributes, true);
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

    // DELETE

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

    public function deleteUser(string $id):bool
    {
        return $this->query("DELETE FROM users WHERE id = ?", [$id], true);
    }

    // QUERY

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
}
