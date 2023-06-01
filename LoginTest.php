<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    protected function assertHeaderContains($expected, $header)
    {
        $this->assertStringContainsString($expected, $header);
    }

    public function testEmptyInput()
    {
        $_POST = [
            'login' => 'login',
            'username' => '',
            'password' => ''
        ];

        ob_start();
        require 'login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Inserisci username e password', $output);
    }

    public function testCorrectAuthentication()
    {
        $_POST = [
            'login' => 'login',
            'username' => 'valid_user',
            'password' => 'valid_password'
        ];

        // Mock the database response
        $mockPDO = $this->createMock(PDO::class);
        $mockPDOStatement = $this->createMock(PDOStatement::class);
        $mockPDO->method('prepare')->willReturn($mockPDOStatement);

        // Restituisci una password già hashed nel tuo mock
        $hashedPassword = password_hash('valid_password', PASSWORD_DEFAULT);
        $user = [
            'username' => 'valid_user',
            'password' => $hashedPassword
        ];

        // Restituisci l'utente dal tuo mock quando viene chiamato il metodo fetch
        $mockPDOStatement->method('fetch')->willReturn($user);

        // Sostituisci la variabile globale $pdo con il tuo mock
        $GLOBALS['pdo'] = $mockPDO;

        ob_start();
        require 'login.php';
        $output = ob_get_clean();

        // Dovresti verificare che l'output NON contenga il messaggio di errore
        $this->assertStringNotContainsString('Credenziali utente errate', $output);

        // E anche che l'output dovrebbe indicare un redirect all'indexlog.html
        $this->assertStringContainsString('Location: indexlog.html', $output);
    }

    public function testIncorrectAuthentication()
    {
        $_POST = [
            'login' => 'login',
            'username' => 'invalid_user',
            'password' => 'invalid_password'
        ];

        // Mock the database response
        $mockPDO = $this->createMock(PDO::class);
        $mockPDOStatement = $this->createMock(PDOStatement::class);

        // Make the query method return the mock PDOStatement
        $mockPDO->method('prepare')
                ->willReturn($mockPDOStatement);

        // Make the fetch method return false
        $mockPDOStatement->method('fetch')
                ->willReturn(false);

        // Substitute the global $pdo variable with your mock
        $GLOBALS['pdo'] = $mockPDO;

        // Capture the output
        ob_start();
        require 'login.php';
        $output = ob_get_clean();

        // Verify that the user saw the error message
        $this->assertStringContainsString('Credenziali utente errate', $output);
    }
}
