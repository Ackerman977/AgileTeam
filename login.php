<?php
// Avvia la sessione
session_start();

// Richiede il file di connessione al database
require_once('connection.php');

// Se il form di login è stato inviato
if (isset($_POST['login'])) {
    // Verifica se la funzione login() è già stata definita
    if (!function_exists('login')) {
        // Funzione di login
        function login($pdo)
        {
            // Ottieni username e password dai dati del form
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Se l'username o la password sono vuoti, mostra un messaggio di errore
            if (empty($username) || empty($password)) {
                $msg = 'Inserisci username e password';
                echo '<script>alert("' . $msg . '");</script>';
                return; // Termina l'esecuzione della funzione
            }

            // Prepara una query SELECT per recuperare le informazioni dell'utente
            $query = "SELECT username, password FROM utenti WHERE username = :username";

            try {
                // Esegui la query con l'username fornito
                $check = $pdo->prepare($query);
                $check->bindParam(':username', $username, PDO::PARAM_STR);
                $check->execute();

                // Ottieni i dati dell'utente dal risultato della query
                $user = $check->fetch(PDO::FETCH_ASSOC);

                // Se l'utente non esiste o la password non corrisponde, mostra un messaggio di errore
                if (!$user || !password_verify($password, $user['password'])) {
                    $msg = 'Credenziali utente errate';
                    echo '<script>alert("' . $msg . '");</script>';
                } else {
                    // Rigenera l'ID di sessione e salva le informazioni dell'utente nella sessione
                    session_regenerate_id();
                    $_SESSION['session_id'] = session_id();
                    $_SESSION['session_user'] = $user['username'];
                    header("Location: indexlog.html");
                    exit();
                }
            } catch (PDOException $e) {
                // Gestione dell'errore di esecuzione della query
                $msg = 'Si è verificato un errore. Per favore prova più tardi.';
                echo '<script>alert("' . $msg . '");</script>';
                error_log('Errore durante l\'esecuzione della query: ' . $e->getMessage());
            }
        }
    }

    // Usa $pdo da variabile globale se esiste, altrimenti crea uno nuovo
    $pdo = $GLOBALS['pdo'] ?? createPDO();

    if ($pdo !== null) {
        login($pdo);
    }
}
?>
