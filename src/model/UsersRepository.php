<?php

namespace App\model;

use App\model\User;
use PDO;
use PDOException;


class UsersRepository
{
    private PDO $db;
    private string $filedb;

    public function __construct()
    {
        $this->filedb = __DIR__ . "/../../users.db";
        $this->db = UsersRepository::getConnection($this->filedb);
    }

    // Retorna uma array contendo erros, se hover algum
    // o formulario vai ser mostrado novamente.
    public function create(User $user): array {

        if ($this->validateNewUserEntries($user)) {
            if (!$this->userAlreadyExists($user))
                $newId = $this->getNextId();

            /* Salva usuario dados no banco de dados. */
            $sql = 'INSERT INTO users VALUES(:id, :fullname, :username, :email, :birthday, :genre, :city, :country, :phone, :password)';

            $command = $this->db->prepare($sql);
            $command->execute(
                [
                    "id" => $newId,
                    "fullname" => $user->fullname,
                    "username" => $user->username,
                    "email" => $user->email,
                    "birthday" => $user->birthday,
                    "genre" => $user->genre,
                    "city" => $user->city,
                    "country" => $user->country,
                    "phone" => $user->phone,
                    "password" => $user->password
                ]
            );
        }

        return $user->errors;
    }

    public function deleteAll(): void {
        $this->db->exec("DELETE FROM users");
    }

    public function findAll(): array {
        // ler todo banco de dados de usario
        $command = $this->db->prepare("SELECT * FROM users");
        $users = [];

        // processa e amazena todos os usuario numa lista.
        while($user = $command->fetch(PDO::FETCH_OBJ)) {
            $newUser = new User(
                $user->fullname,
                $user->username,
                $user->password,
                $user->email,
                $user->birthday,
                $user->genre,
                $user->city,
                $user->phone,
                $user->country,
                $user->agreement
            );
            $users[] = $newUser;
        }

        return $users;
    }

    /* processamento dos dados do novo usuario. */
    private function validateNewUserEntries(User $user): bool
    {

        if (empty($user->fullname)) {
            $user->errors[] = 'O nome completo é um campo obrigatorio.';
        }

        if (empty($user->birthday)) {
            $user->errors[] = 'Data de nascimento é um campo obrigatorio.';
        }

        if (empty($user->genre)) {
            $user->errors[] = 'Genero é um campo obrigatorio.';
        }

        if (empty($user->city)) {
            $user->errors[] = 'Cidade é um campo obrigatorio.';
        }

        if (empty($user->phone)) {
            $user->errors[] = 'Numero de telefone é um campo obrigatorio.';
        }

        if (empty($user->country) || $user->country == "default") {
            $user->errors[] = 'País é um campo obrigatorio';
        }

        if (empty($user->username)) {
            $user->errors[] = "Nome de usuario é um campo obrigatorio.";
        }

        if (empty($user->password)) {
            $user->errors[] = "Senha é um campo obrigatoria.";
        }

        if (empty($user->email)) {
            $user->errors[] = "Email é um campo obrigatorio.";
        }

        if (empty($user->agreement)) {
            $user->errors[] = 'Voçê deve aceitar os termos e condições.';
        }


        if (strlen($user->fullname) > 0 && !preg_match('/^[a-zA-Z\s]+$/', $user->fullname)) {
            $errors[] = "O nome completo fornecido é invalido.";
        }


        try {
            if (strlen($user->birthday) > 0) {
                $birthday = new \DateTime($user->birthday);
            }
        } catch (\DateMalformedStringException $e) {
            $errors[] = 'A data de nacimento fornecida é invalida.';
        }

        /* simples verificaçao do email fornecido */
        if (strlen($user->email) > 0 && !preg_match('/^[-_a-zA-Z0-9]+@[a-zA-Z0-9]+?\.\w{3}+$/', $user->email)) {
            $user->errors[] = "O email fornecido é invalido.";
        }


        if (strlen($user->password) > 0 && strlen($user->password) < 6) {
            $errors[] = 'A senha deve ter pelo menos 6 caracteres.';
        }


        if (strlen($user->agreement) > 0 && $user->agreement != 'ok') {
            $errors[] = 'Voçê deve aceitar termos e condições.';
        }

        return count($user->errors) == 0;
    }



    /* Verifica se usuario ja existe. */
    private function userAlreadyExists(User $user): bool
    {
        $sql = "SELECT * FROM users WHERE email=:email OR username=:username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":username", $user->username);
        $stmt->execute();
        $entry = $stmt->fetch(PDO::FETCH_OBJ);
        if ($entry) {
            if($entry->email == $user->email) {
            $user->errors[] = "O email já existe no sistema.";
            }
            if($entry->username == $user->username) {
                $user->errors[] = "O nome de usuario já existe no sistema.";
            }
            return true;
        }
        return false;
    }

    private function getNextId(): int
    {
        $id = 0;
        $sql = "SELECT id FROM users ORDER BY id DESC limit 1";
        $command = $this->db->prepare($sql);
        $command->execute();
        $entry = $command->fetch(PDO::FETCH_OBJ);
        if ($entry) {
            $id = $entry->id;
        }
        return $id + 1;
    }

    private static function getConnection(string $filedb): PDO
    {
        $db = null;

        /* cria arquivo do banco de dados se ele não existe. */
        try {
            $db = new PDO("sqlite:$filedb");
            //$sql = "DROP TABLE IF EXISTS users";
            //$db->exec($sql); // remove a tabela toda vez.


            /* Cria tabela para manter informacões sobre usuarios se ele java não existir */
            $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS users(
            id INT PRIMARY KEY,
            fullname VARCHAR(120),
            username VARCHAR(60),
            email VARCHAR(60),
            birthday DATETIME,     
            genre INT,
            city VARCHAR(60),
            country VARCHAR(60),    
            phone VARCHAR(10),
            password VARCHAR(128)
            )
            SQL;

            $db->exec($sql);
        } catch (PDOException $e) {
            echo 'Error: ' . htmlspecialchars($e->getMessage()); /* debug only */
            exit();
        }

        return $db;
    }
}
