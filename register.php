<?php

require_once('connection.php');

if (isset($_POST['register'])) {
    $nome = $_POST['nome'] ?? '';
    $cognome = $_POST['cognome'] ?? '';
    $numero_telefono = $_POST['numero_telefono'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $socio = isset($_POST['socio']) ? 1 : 0;
    $socioPlus = isset($_POST['socio_plus']) ? 1 : 0;
    $tipoAbbonamento = $_POST['tipo_abbonamento'] ?? '';


    $query = "SELECT id FROM utenti WHERE nome = :nome OR email = :email OR username = :username";
    $check = $pdo->prepare($query);
    $check->bindParam(':nome', $nome, PDO::PARAM_STR);
    $check->bindParam(':email', $email, PDO::PARAM_STR);
    $check->bindParam(':username', $username, PDO::PARAM_STR);
    $check->execute();
    $existingUsers = $check->fetchAll(PDO::FETCH_ASSOC);

    if (count($existingUsers) > 0) {
        $msg = 'Name, email, or username already in use: %s';
    } elseif (trim($nome) === '') {
        $msg = 'The "Nome" field is required: %s';
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Please enter a valid email address: %s';
    } elseif (!preg_match("/^[a-z\d_]{3,20}$/i", $username)) {
        $msg = 'The username is not valid. Only alphanumeric characters and underscore are allowed. Minimum length: 3 characters. Maximum length: 20 characters: %s';
    } elseif (strlen($password) < 8 || strlen($password) > 20) {
        $msg = 'Password length should be between 8 and 20 characters: %s';
    } else {
        $query = "SELECT id FROM utenti WHERE email = :email";
        $checkEmail = $pdo->prepare($query);
        $checkEmail->bindParam(':email', $email, PDO::PARAM_STR);
        $checkEmail->execute();
        $existingEmail = $checkEmail->fetchAll(PDO::FETCH_ASSOC);

        if (count($existingEmail) > 0) {
            $msg = 'The email is already in use: %s';
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO utenti (nome, cognome, numero_telefono, username, password, email, socio, socio_plus, tipo_abbonamento) VALUES (:nome, :cognome, :numero_telefono, :username, :password, :email, :socio, :socio_plus, :tipo_abbonamento)";
            $registerUser = $pdo->prepare($query);
            $registerUser->bindParam(':nome', $nome, PDO::PARAM_STR);
            $registerUser->bindParam(':cognome', $cognome, PDO::PARAM_STR);
            $registerUser->bindParam(':numero_telefono', $numero_telefono, PDO::PARAM_STR);
            $registerUser->bindParam(':username', $username, PDO::PARAM_STR);
            $registerUser->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $registerUser->bindParam(':email', $email, PDO::PARAM_STR);
            $registerUser->bindParam(':socio', $socio, PDO::PARAM_INT);
            $registerUser->bindParam(':socio_plus', $socioPlus, PDO::PARAM_INT);
            $registerUser->bindParam(':tipo_abbonamento', $tipoAbbonamento, PDO::PARAM_STR);            
            $registerUser->execute();
        }
    header("Location: indexlog.html");
    exit();
    }
}
?>