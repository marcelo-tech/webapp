<?php



namespace App\model;

use PDO;
use DateMalformedStringException;
use DateTime;
use PDOException;

// diretorio raiz do projecto
define("DB_FILENAME", "../../users.db");


// manipula dados de usuarios e verifica se os dados fornecidos estão 
// corretos, tambem salvo no banco de dados.
class User
{

    public function __construct(
        public string $fullname = "",
        public string $username = "",
        public string $password = "",
        public string $email = "",
        public string $birthday = "",
        public string $genre = "",
        public string $city = "",
        public string $phone = "",
        public string $country = "",
        public string $agreement = "",
        public array $errors = []
    ) {}

    public function sanitizeUserEntries(): void
    {
        /* Dados invalido ou dados valido com espaços no inicio o no fim são verificados. */
        $this->fullname = trim($_POST['fullname'] ?? "");
        $this->username = trim($_POST['username'] ?? "");
        $this->password  = trim($_POST['password'] ?? "");
        $this->email = trim($_POST['email'] ?? "");
        $this->birthday = trim($_POST['birthday'] ?? ""); /* data (datetime) */
        $this->genre = trim($_POST['genre'] ?? "");  /* select button */
        $this->city = trim($_POST['city'] ?? "");
        $this->phone = trim($_POST['phone'] ?? "");
        $this->country = trim($_POST['country'] ?? "");
        $this->agreement = trim($_POST['agreement'] ?? ""); /* checkbox */
        $this->errors = [];
    }
}
