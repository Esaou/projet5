<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

class FrontManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function encadre()
    {
        return $this->database->getDb()->query("SELECT * FROM accueil ORDER BY id DESC", 'App\Models\BackOffice');
    }

    public function activites()
    {
        return $this->database->getDb()->query("SELECT * FROM activites ORDER BY id", 'App\Models\BackOffice');
    }

    public function form()
    {
        return new \App\Service\BootstrapForm();
    }
}
