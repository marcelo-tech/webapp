<?php


namespace App\controller;

use App\model\User;
use App\model\UsersRepository;


class UsersController
{
    private function loadTemplate(string $template, array $errors): void
    {
        require_once __DIR__ . "/../views/$template";
    }

    public function displayForm(array $errors)
    {
        // mostra formulario para o usuario
        $this->loadTemplate("webapp.php", $errors);
    }

    public function processUserData(): void
    {
        $usersRepository = new UsersRepository();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = new User();
            $user->sanitizeUserEntries();
            $errors = $usersRepository->create($user);
        }

        if (count($errors) > 0) {
            // recarega com mensagens de erros.
            // $this->loadTemplate("webapp.php", $errors);
            $this->displayForm($errors);
            die;
        }

        // secesso!!!
        $this->loadTemplate("ConfirmRegister.php", $errors);
    }

    public function deleteAllUsers(): void {
        $usersRepository = new UsersRepository();
        $usersRepository->deleteAll();
        $this->loadTemplate("ConfirmDelete.php", []);
    }

    public function displayAllUsers(): void {
        $usersRepository = new UsersRepository();
        $users = $usersRepository->findAll();
        $this->loadTemplate("DisplayUsers.php", []);
    }
}
