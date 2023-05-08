<?php

require_once('connection.php');


$email = $conn->real_escape_string($_POST['email']);
$password = $conn->real_escape_string($_POST['password']);

if($_SERVER["REQUEST_METHOD"] === "POST"){

$sql_select ="SELECT * FROM users WHERE email = '$email";
if($result = $conn->query($sql_select)){
    if($result->num_rows == 1){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if(password_verify($password, $row['password'])){
            session_start();
            
            $_SESSION['loggato'] = true;
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];

            header("location: are_privata.php");
        }else{
            echo "la password non è corretta";
        }
    }else{
        echo "non ci sono account con quello username";
    }
    }
    $conn->close();
}
