<?php

namespace App;

use App\controller\UsersController;

class Application
{
    public function init(): void
    {
        $uri = $_SERVER['REQUEST_URI'] ?? "";
        $usersController = new UsersController();

        switch ($uri) {
            case "/":
            case "/webapp":
                // inicial requisição, nenhum error existes
                $errors = [];
                $usersController->displayForm($errors);
                break;

            case "/users/new":
                $usersController->processUserData();
                break;

            case "/users/delete/all":
                $usersController->deleteAllUsers();
                break;

            case "/users/all":
                $usersController->displayAllUsers();
                break;
        }
    }
}
