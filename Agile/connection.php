<?php
// Definizione di un array di configurazione per il database
$config = [
    'db_engine' => 'mysql', // tipo di motore del database (in questo caso MySQL)
    'db_host' => '127.0.0.1', // indirizzo IP del server MySQL
    'db_name' => 'agile_db', // nome del database
    'db_user' => 'root', // nome utente per accedere al database
    'db_password' => '', // password per accedere al database
];

// Costruzione della stringa di configurazione per PDO
$db_config = $config['db_engine'] . ":host=".$config['db_host'] . ";dbname=" . $config['db_name'];

try {
    // Creazione di un'istanza di PDO (classe PHP per l'accesso al database)
    $pdo = new PDO($db_config, $config['db_user'], $config['db_password'], [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" // impostazione del set di caratteri da utilizzare per la connessione al database
    ]);
    
    // Impostazione delle opzioni di PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // abilitazione della gestione degli errori in PDO
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // disabilitazione dell'emulazione delle prepared statements in PDO
} catch (PDOException $e) {
    // Gestione dell'eccezione in caso di errore di connessione al database
    exit("Impossibile connettersi al database: " . $e->getMessage());
}
