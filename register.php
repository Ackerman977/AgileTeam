<?php
require_once('connection.php');

$pdo = createPDO(); // Create a new PDO object

function registerUser($pdo, $nome, $cognome, $numero_telefono, $username, $password, $email, $socio, $socio_plus, $tipo_abbonamento) {
    $msg = '';
    // Check if user with the same name, email, or username exists
    $query = "SELECT id FROM utenti WHERE nome = :nome OR email = :email OR username = :username";
    $check = $pdo->prepare($query);
    $check->bindParam(':nome', $nome, PDO::PARAM_STR);
    $check->bindParam(':email', $email, PDO::PARAM_STR);
    $check->bindParam(':username', $username, PDO::PARAM_STR);
    $check->execute();
    $existingUsers = $check->fetchAll(PDO::FETCH_ASSOC);

    if (count($existingUsers) > 0) {
        $msg = 'Name, email, or username already in use.';
    } elseif (trim($nome) === '') {
        $msg = 'The "Nome" field is required.';
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Please enter a valid email address.';
    } elseif (!preg_match("/^[a-z\d_]{3,20}$/i", $username)) {
        $msg = 'The username is not valid. Only alphanumeric characters and underscore are allowed. Minimum length: 3 characters. Maximum length: 20 characters.';
    } elseif (strlen($password) < 8 || strlen($password) > 20) {
        $msg = 'Password length should be between 8 and 20 characters.';
    } else {
        // Create password hash
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Insert user data into the database
        $query = "INSERT INTO agile_db.utenti(nome, cognome, numero_telefono, username, password, email, socio, socio_plus, tipo_abbonamento) 
                  VALUES (:nome, :cognome, :numero_telefono, :username, :password, :email, :socio, :socio_plus, :tipo_abbonamento)";
        $registerUser = $pdo->prepare($query);
        $registerUser->bindParam(':nome', $nome, PDO::PARAM_STR);
        $registerUser->bindParam(':cognome', $cognome, PDO::PARAM_STR);
        $registerUser->bindParam(':numero_telefono', $numero_telefono, PDO::PARAM_STR);
        $registerUser->bindParam(':username', $username, PDO::PARAM_STR);
        $registerUser->bindParam(':password', $password_hash, PDO::PARAM_STR);
        $registerUser->bindParam(':email', $email, PDO::PARAM_STR);
        $registerUser->bindParam(':socio', $socio, PDO::PARAM_INT);
        $registerUser->bindParam(':socio_plus', $socio_plus, PDO::PARAM_INT);
        $registerUser->bindParam(':tipo_abbonamento', $tipo_abbonamento, PDO::PARAM_STR);            
        $registerUser->execute();

        $msg = 'Registration successful';
    }
    return $msg;
}
?>
