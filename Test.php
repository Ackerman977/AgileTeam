<?php
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Crea un nuovo PDO utilizzando SQLite in memoria
        $this->pdo = new PDO('sqlite::memory:');

        // Crea la tabella degli utenti nel database di test
        $query = "
            CREATE TABLE utenti (
                id INTEGER PRIMARY KEY,
                nome TEXT NOT NULL,
                cognome TEXT NOT NULL,
                numero_telefono TEXT,
                username TEXT NOT NULL,
                password TEXT NOT NULL,
                email TEXT NOT NULL,
                socio INTEGER NOT NULL,
                socio_plus INTEGER NOT NULL,
                tipo_abbonamento TEXT NOT NULL
            )
        ";
        $this->pdo->exec($query);

        // Includi il file di registrazione che ora utilizza $this->pdo
        require_once 'register.php';
    }

    public function testEmptyName()
    {
        $result = registerUser($this->pdo, '', 'testSurname', 'testPhoneNumber', 'testUsername', 'testPassword123', 'test@test.com', 0, 0, 'testSubscriptionType');
        $this->assertEquals('The "Nome" field is required.', $result);
    }

    public function testInvalidEmail()
    {
        $result = registerUser($this->pdo, 'testName', 'testSurname', 'testPhoneNumber', 'testUsername', 'testPassword123', 'invalidEmail', 0, 0, 'testSubscriptionType');
        $this->assertEquals('Please enter a valid email address.', $result);
    }

    public function testInvalidUsername()
    {
        $result = registerUser($this->pdo, 'testName', 'testSurname', 'testPhoneNumber', 'test/Username', 'testPassword123', 'test@test.com', 0, 0, 'testSubscriptionType');
        $this->assertEquals('The username is not valid. Only alphanumeric characters and underscore are allowed. Minimum length: 3 characters. Maximum length: 20 characters.', $result);
    }

    public function testInvalidPassword()
    {
        $result = registerUser($this->pdo, 'testName', 'testSurname', 'testPhoneNumber', 'testUsername', 'test', 'test@test.com', 0, 0, 'testSubscriptionType');
        $this->assertEquals('Password length should be between 8 and 20 characters.', $result);
    }

    public function testDuplicateEmail()
    {
    // First registration should succeed
    $result = registerUser($this->pdo, 'testName', 'testSurname', 'testPhoneNumber', 'testUsername', 'testPassword123', 'test@test.com', 0, 0, 'testSubscriptionType');
    $this->assertEquals('', $result);  // Assuming the function returns an empty string on successful registration

    // Second registration should fail
    $result = registerUser($this->pdo, 'testName2', 'testSurname2', 'testPhoneNumber2', 'testUsername2', 'testPassword123', 'test@test.com', 0, 0, 'testSubscriptionType');
    $this->assertEquals('Name, email, or username already in use.', $result);
    }

    public function testSuccessfulRegistration()
    {
    $result = registerUser($this->pdo, 'testName', 'testSurname', 'testPhoneNumber', 'testUsername', 'testPassword123', 'testporcod@test.com', 0, 0, 'testSubscriptionType');
    $this->assertEquals('Registrazione avvenuta con successo', $result);
    }

}
