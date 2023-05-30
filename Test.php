<?php
use PHPUnit\Framework\TestCase;

class RegistrationTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
    putenv('DB_ENV=test'); // Imposta la variabile d'ambiente DB_ENV a 'test'

    require_once 'connection.php'; // Include il file di connessione
    $this->pdo = createPDO(getenv('DB_ENV')); // Crea la connessione al database corretto in base all'ambiente

    // Rimuove l'utente di test se esiste
    $query = "DELETE FROM utenti WHERE email = 'test@test.com'";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();

    require_once 'register.php'; // Include il file di registrazione
    }


    protected function tearDown(): void
    {
        // Pulisci il database dopo ogni test
        $query = "DELETE FROM utenti WHERE email = 'test@test.com'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        parent::tearDown();
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
        $this->assertEquals('Registration successful', $result);
        
        // Second registration should fail
        $result = registerUser($this->pdo, 'testName2', 'testSurname2', 'testPhoneNumber2', 'testUsername2', 'testPassword123', 'test@test.com', 0, 0, 'testSubscriptionType');
        $this->assertEquals('The email is already in use.', $result);
    }
    
    public function testSuccessfulRegistration()
    {
        $result = registerUser($this->pdo, 'testName', 'testSurname', 'testPhoneNumber', 'testUsername', 'testPassword123', 'test@test.com', 0, 0, 'testSubscriptionType');
        $this->assertEquals('Registration successful', $result);
    }
}
