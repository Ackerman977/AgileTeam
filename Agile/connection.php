<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agile_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->error);
} 
echo "Connessione al database stabilita con successo";
?>
