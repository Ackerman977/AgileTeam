<?php
// avvia la sessione
session_start();

// distrugge la sessione corrente
session_destroy();

// reindirizza l'utente alla pagina di login
header('Location: login.html');
exit;
