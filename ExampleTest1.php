<?php
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testLogin()
    {
        $user = [
            'username' => 'testuser',
            'password' => password_hash('testpassword', PASSWORD_DEFAULT)
        ];

        // Simula la richiesta POST con le credenziali dell'utente
        $password = 'testpassword';

        // Esegui la funzione da testare
        $result = $this->login($user, $password);

        // Verifica che la funzione restituisca true
        $this->assertTrue($result);
    }

    private function login($user, $password)
    {
        if (!$user || password_verify($password, $user['password']) === false) {
            $msg = 'Credenziali utente errate %s';
        } else {
            // rigenera l'ID di sessione e salva le informazioni dell'utente nella sessione
            // ...

            // reindirizza l'utente alla dashboard
            // ...
        }

        return true;
    }
}
