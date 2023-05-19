<?php
use PHPUnit\Framework\TestCase;

class ExampleTest1 extends TestCase
{
    public function testRegistrationValidation()
    {
        $existingUsers = ['user1']; // Array di utenti esistenti
        $nome = 'john';
        $email = 'john.doe@example.com';
        $username = 'johndoe';
        $password = 'password123';

        // Verifica se il messaggio è corretto quando ci sono utenti esistenti
        $this->assertTrue($this->validateRegistration($existingUsers, $nome, $email, $username, $password, 'Name, email, or username already in use: %s'));

        // Verifica se il messaggio è corretto quando il campo "Nome" è vuoto
        $this->assertEquals('The "Nome" field is required.', $this->validateRegistration($existingUsers, '', $email, $username, $password, 'The "Nome" field is required.'));
        // Verifica se il messaggio è corretto quando l'email non è valida
        $this->assertFalse($this->validateRegistration($existingUsers, $nome, 'invalid_email', $username, $password, 'Please enter a valid email address: %s'));

        // Verifica se il messaggio è corretto quando lo username non è valido
        $this->assertTrue($this->validateRegistration($existingUsers, $nome, $email, 'invalid_username', $password, 'The username is not valid. Only alphanumeric characters and underscore are allowed. Minimum length: 3 characters. Maximum length: 20 characters: %s'));

        // Verifica se il messaggio è corretto quando la lunghezza della password non è valida
        $this->assertFalse($this->validateRegistration($existingUsers, $nome, $email, $username, 'short', 'Password length should be between 8 and 20 characters: %s'));

        // Verifica se il messaggio è corretto quando tutti i dati sono validi
        $this->assertTrue($this->validateRegistration($existingUsers, $nome, $email, $username, $password, '')); // Non dovrebbe esserci alcun messaggio di errore
    }

    public function validateRegistration($existingUsers, $nome, $email, $username, $password, $expectedErrorMessage)
    {
        $msg = '';
    
        if (in_array($username, $existingUsers)) {
            $msg = $expectedErrorMessage;
            return false;
        } elseif (trim($nome) === '') {
            $msg = $expectedErrorMessage;
            return $msg;
        } elseif (empty($email)) {
            $msg = sprintf($expectedErrorMessage, $email);
            return false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = sprintf($expectedErrorMessage, $email);
            return false;
        } elseif (!preg_match("/^[a-z\d_]{3,20}$/i", $username)) {
            $msg = sprintf($expectedErrorMessage, $username);
            return false;
        } elseif (strlen($password) < 8 || strlen($password) > 20) {
            $msg = sprintf($expectedErrorMessage, $password);
            return false;
        }
    
        // Output debug information
        echo "Existing Users: " . implode(', ', $existingUsers) . PHP_EOL;
        echo "Username: " . $username . PHP_EOL;
        echo "Nome: " . $nome . PHP_EOL;
        echo "Email: " . $email . PHP_EOL;
        echo "Password: " . $password . PHP_EOL;
        
        // Verifica se il messaggio di errore non è vuoto
        $this->assertEmpty($msg, $expectedErrorMessage);
    
        return $msg === '';
    }
    
}
