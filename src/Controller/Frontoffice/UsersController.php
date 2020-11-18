<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Model\FrontManager;
use App\Model\UsersManager;
use App\Service\Database;
use App\View\View;

class UsersController
{
    private UsersManager $usersManager;
    private FrontManager $frontManager;
    private Database $database;
    private View $view;

    public function __construct(UsersManager $usersManager, FrontManager $frontManager, View $view, Database $database)
    {
        $this->view = $view;
        $this->database = $database;
        $this->frontManager = $frontManager;
        $this->usersManager = $usersManager;
    }

    public function login():void
    {
        $this->usersManager->login();
    }
}
