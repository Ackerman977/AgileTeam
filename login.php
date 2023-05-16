<?php
// avvia la sessione
session_start();
// richiede il file di connessione al database
require_once('connection.php');

// se l'utente è già loggato, reindirizzalo alla dashboard
if (isset($_SESSION['session_id'])) {
    header('dashboard.php');
    exit;
}

// se il form di login è stato inviato
if (isset($_POST['login'])) {
    // ottieni username e password dai dati del form
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // se l'username o la password sono vuoti, mostra un messaggio di errore
    if (empty($username) || empty($password)) {
        $msg = 'Inserisci username e password %s';
    } else {
        // prepara una query SELECT per recuperare le informazioni dell'utente
        $query = "SELECT username, password FROM utenti WHERE username = :username";
        
        // esegui la query con l'username fornito
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();
        
        // ottieni i dati dell'utente dal risultato della query
        $user = $check->fetch(PDO::FETCH_ASSOC);
        
        // se l'utente non esiste o la password non corrisponde, mostra un messaggio di errore
        if (!$user || password_verify($password, $user['password']) === false) {
            $msg = 'Credenziali utente errate %s';
        } else {
            // rigenera l'ID di sessione e salva le informazioni dell'utente nella sessione
            session_regenerate_id();
            $_SESSION['session_id'] = session_id();
            $_SESSION['session_user'] = $user['username'];
            
            // reindirizza l'utente alla dashboard
            header('Location: dashboard.php');
            exit;
        }
    }    
}
printf($msg, '<a href="index.html">torna indietro</a>');

<<<<<<< HEAD
?>
=======
echo "benvenuto";
?>
>>>>>>> 4a081ac7edbdedd8ceecca231aa558200e780698
