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

    public function lastActivite()
    {
        return $this->database->getDb()->query("SELECT * FROM activites ORDER BY id DESC LIMIT 0,1", 'App\Models\BackManager');
    }

    public function lastProfessionnel()
    {
        return $this->database->getDb()->query("SELECT * FROM professionnels ORDER BY id DESC LIMIT 0,1", 'App\Models\BackManager');
    }

    public function lastMessage()
    {
        return $this->database->getDb()->query("SELECT * FROM messages ORDER BY id DESC LIMIT 0,1", 'App\Models\BackManager');
    }

    public function allActivites()
    {
        return $this->database->getDb()->query("SELECT * FROM activites ORDER BY id DESC", 'App\Models\BackManager');
    }

    public function allMessages()
    {
        return $this->database->getDb()->query("SELECT * FROM messages ORDER BY id DESC", 'App\Models\BackManager');
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
