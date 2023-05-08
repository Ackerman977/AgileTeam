<?php

  require_once('connection.php');

  // controlla se la richiesta è stata inviata tramite POST

    
    // ottiene i valori dei campi dal form
    $name = $conn->real_escape_string($_POST['name']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    

    // esegue la query per inserire i dati nel database
    $sql = "INSERT INTO users (name, surname, email, password) VALUES ('$name', '$surname', '$email', '$password')";

    if($conn->query($sql) === true) {
      // se l'inserimento è andato a buon fine, reindirizza l'utente alla pagina di successo
        echo  "Registrazione effettuata con successo";
    } else {
      // se c'è stato un errore nell'inserimento, mostra un messaggio di errore
      echo "Errore nell'inserimento dei dati nel database: $sql. " . $conn->error;
    }
?>
