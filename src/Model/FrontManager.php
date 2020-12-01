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

    // CREATE

    public function createMessage(array $fields):bool
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("INSERT INTO messages SET $sqlPart", $attributes, true);
    }

    // CONTENT

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

    // FORM

    public function form()
    {
        return new \App\Service\BootstrapForm();
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
